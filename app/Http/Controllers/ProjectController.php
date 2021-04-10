<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PhpParser\PrettyPrinter\Standard;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            Project::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param CreateProjectRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProjectRequest $request): \Illuminate\Http\JsonResponse
    {
        if(Auth::user()->can('create')) {
            $project = new Project($request->all());
            $project->company()->associate(Company::find($request->get('company')));
            $project->createdBy()->associate(Auth::user());
            $project->save();

            return StandardResponse::getStandardResponse(
                Response::HTTP_CREATED,
                "Project Successfully Created"
            );
        }else{
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Create A Project"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\project  $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(project $project)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            $project
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\project  $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(project $project)
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
     * @param  \App\Models\project  $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProjectRequest $request, project $project)
    {
        if (Auth::user()->can('update', $project)) {
            $project->fill($request->all())->save();

            return StandardResponse::getStandardResponse(
                Response::HTTP_OK,
                "Project Successfully Updated"
            );
        }else{
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Edit This Project"
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\project  $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(project $project)
    {
        if (Auth::user()->can('update', $project)) {
            $project->delete();

            return StandardResponse::getStandardResponse(
                Response::HTTP_NO_CONTENT,
                "Project Successfully Deleted"
            );
        }else{
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Delete This Project"
            );
        }
    }
}
