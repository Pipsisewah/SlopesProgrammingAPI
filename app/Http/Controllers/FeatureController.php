<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeatureRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            200,
            "Features",
            $features->all()
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
            404,
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
        foreach ($request->get('tags') as $tag) {
            $feature->tag()->attach($tag);
        }
        return StandardResponse::getStandardResponse(
            201,
            "Feature Successfully Created"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
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
            404,
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
    public function update(Request $request, Feature $feature)
    {
        return StandardResponse::getStandardResponse(
            404,
            "Route Not Available"
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
                201,
                "Feature Successfully Deleted"
            );
        }else{
            return StandardResponse::getStandardResponse(
                403,
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
            200,
            "Would have attached",
            ['feature' => $feature,
                'tag' => $tag]
        );
    }
}
