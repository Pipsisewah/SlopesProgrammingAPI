<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserDataRequest;
use App\Http\Responses\StandardResponse;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserDataController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return StandardResponse::getStandardResponse(
                Response::HTTP_OK,
                Auth::user()->userData()->firstOrFail()
            );
        }catch (\Exception $exception){
            return StandardResponse::getStandardResponse(
                Response::HTTP_NOT_FOUND,
                "No user data found"
            );
        }
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
     * @param CreateUserDataRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserDataRequest $request)
    {
        $userData = new UserData($request->all());
        $userData->user()->associate(Auth::user());
        $userData->save();
        return StandardResponse::getStandardResponse(
            Response::HTTP_CREATED,
            "UserData Successfully Saved"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
            $userData = UserData::findOrFail($id);
            if(Auth::user()->can('view', $userData)){
                return StandardResponse::getStandardResponse(
                    200,
                    "User Data",
                    ["data" => $userData]
                );
            } else {
                return StandardResponse::getStandardResponse(
                    Response::HTTP_FORBIDDEN,
                    "You Are Not Authorized To View This User's Data"
                );
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserData  $userData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(UserData $userData)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUserDataRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUserDataRequest $request, int $id)
    {
        $userData = UserData::query()->findOrFail($id);
        /** @var User $user */
        $user = Auth::user();
        Log::notice("Provided ID: " . $id);
        if($user->can('edit', $userData)){
            $userData->fill($request->all());
            $userData->user()->associate(Auth::user());
            $userData->save();
            return StandardResponse::getStandardResponse(
                200,
                "User Data",
                ["data" => $userData->fresh()]
            );
        } else {
            return StandardResponse::getStandardResponse(
                Response::HTTP_FORBIDDEN,
                "You Are Not Authorized To View This User's Data"
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserData  $userData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserData $userData)
    {
        return StandardResponse::getStandardResponse(
            Response::HTTP_NOT_FOUND,
            "Route Not Available"
        );
    }
}
