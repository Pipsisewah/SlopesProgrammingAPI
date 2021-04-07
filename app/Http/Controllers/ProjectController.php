<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
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
        return StandardResponse::getStandardResponse(200,Project::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProjectRequest $request)
    {
        $project = new Project($request->all());
        $project->company()->associate(Company::find($request->get('company')));
        $project->save();
        return StandardResponse::getStandardResponse(
            201,
            "Project Successfully Created"
        );
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
            200,
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
            404,
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
        $project->fill($request->all())->save();
        return StandardResponse::getStandardResponse(
            201,
            "Project Successfully Updated"
        );
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
        $project->delete();
        return StandardResponse::getStandardResponse(
            201,
            "Project Successfully Deleted"
        );
    }
}
