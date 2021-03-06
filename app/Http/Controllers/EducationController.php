<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachDetachUserWithEducationRequest;
use App\Http\Requests\CreateEducationRequest;
use App\Http\Requests\DetachUserWithEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Education;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            "Education",
            ['data' => Auth::user()->education()->get()->all()]
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return JsonResponse
     */
    public function store(CreateEducationRequest $request)
    {
        $education = new Education($request->all());
        $education->save();
        $education->user()->attach(Auth::user());
        return StandardResponse::getStandardResponse(
            Response::HTTP_CREATED,
            "Education Successfully Created"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     *
     * @return JsonResponse
     */
    public function show(Education $education)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     *
     * @return JsonResponse
     */
    public function edit(Education $education)
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
     * @param  \App\Models\Education  $education
     *
     * @return JsonResponse
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
        if(!Auth::user()->can('update', $education)){
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Update This Education"
            );
        }
        $education->fill($request->all());
        $education->save();
        return StandardResponse::getStandardResponse(
            Response::HTTP_OK,
            "Education Successfully Updated"
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     *
     * @return JsonResponse
     */
    public function destroy(Education $education)
    {
        if(!Auth::user()->can('delete', $education)){
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To Delete This Education"
            );
        }
        try {
            $education->delete();
            return StandardResponse::getStandardResponse(
                Response::HTTP_NO_CONTENT,
                "Education Successfully Deleted"
            );
        }catch (\Exception $exception){
            return StandardResponse::getStandardResponse(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                "Failed To Delete Education"
            );
        }
    }

    public function attachUserWithEducation(Education $education): JsonResponse{
        try {
            if($education->user != null && $education->users->contains(Auth::user())){
                return StandardResponse::getStandardResponse(
                    Response::HTTP_NO_CONTENT,
                    "User Already Associated With Education"
                );
            }
            $education->users()->attach(Auth::user());
            return StandardResponse::getStandardResponse(
                Response::HTTP_NO_CONTENT,
                "Successfully Associated With Education"
            );
        }catch (\Exception $exception){
            Log::error("Failed to associate user with education", ['error' => $exception->getMessage()]);
            return StandardResponse::getStandardResponse(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                "Failed To Associate User With Education"
            );
        }
    }

    public function detachUserWithEducation(Education $education): JsonResponse{
        try{
            $education->users()->detach(Auth::user());
            return StandardResponse::getStandardResponse(
                Response::HTTP_NO_CONTENT,
                "Successfully Detached User From Education"
            );
        }catch (\Exception $exception){
            Log::error("Failed to detach user with education", ['error' => $exception->getMessage()]);
            return StandardResponse::getStandardResponse(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                "Failed To Detach User With Education"
            );
        }
    }
}
