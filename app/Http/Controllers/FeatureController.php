<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $features = Feature::all()->where('user_id', '=', Auth::id());
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            "Features",
            ['data' => $features->all()]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateFeatureRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFeatureRequest $request)
    {
        $project = Project::find($request->get('project'));
        $feature = new Feature($request->all());
        $feature->project()->associate($project);
        $feature->user()->associate(Auth::user());
        $feature->save();
        if(!empty($request->get('tags'))) {
            foreach ($request->get('tags') as $tag) {
                $feature->tag()->attach($tag);
            }
        }
        return StandardResponse::getStandardResponse(
            Response::HTTP_CREATED,
            "Feature Successfully Created"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     *
     * @return JsonResponse
     */
    public function show(Feature $feature)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     *
     * @return JsonResponse
     */
    public function edit(Feature $feature)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $feature
     *
     * @return JsonResponse
     */
    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $feature->fill($request->all());
        $project = Project::find($request->get('project'));
        Log::notice("Project: " . $project);
        $feature->project()->associate($project);
        $feature->save();
        foreach ($request->get('tags') as $tag) {
            $feature->tag()->sync($tag);
        }
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            "Successfully Updated Feature"
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feature  $feature
     *
     * @return JsonResponse
     */
    public function destroy(Feature $feature)
    {
        if (Auth::user()->can('delete', $feature)) {
            $feature->delete();
            return StandardResponse::getStandardResponse(
                Response::HTTP_NO_CONTENT,
                "Feature Successfully Deleted"
            );
        }else{
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Delete This Feature"
            );
        }
    }


    /**
     * @param Feature $feature
     * @param Tag $tag
     *
     * @return JsonResponse
     */
    public function attachTag(Feature $feature, Tag $tag):JsonResponse{
        $feature->tag()->attach($tag);
        $feature->save();
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            "Successfully Attached A Tag To A Feature",
            ['feature' => $feature,
                'tag' => $tag]
        );
    }
}
