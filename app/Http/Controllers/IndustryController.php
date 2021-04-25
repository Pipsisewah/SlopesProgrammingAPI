<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIndustryRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $industries = Industry::all();
        return StandardResponse::getStandardResponse(
            200,
            "All Industries",['data' =>
                                 Industry::all()]
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $industry = new Industry($request->all());
            $industry->save();
            return StandardResponse::getStandardResponse(
                201,
                "Industry Successfully Created"
            );
        }catch (\Exception $exception){
            Log::error("Failed to create industry", ['reason' => $exception->getMessage()]);
            return StandardResponse::getStandardResponse(
                500,
                "Failed To Create Industry"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Industry $industry
     *
     * @return JsonResponse
     */
    public function show(Industry $industry)
    {
        return StandardResponse::getStandardResponse(
            404,
            "Route Not Available"
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Industry  $industry
     *
     * @return JsonResponse
     */
    public function edit(Industry $industry)
    {
        return StandardResponse::getStandardResponse(
            404,
            "Route Not Available"
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIndustryRequest $request
     * @param Industry $industry
     *
     * @return JsonResponse
     */
    public function update(UpdateIndustryRequest $request, Industry $industry): JsonResponse
    {
        try {
            if (Auth::user()->can('update', $industry)) {
                $industry->name = $request->get('name');
                $industry->save();

                return StandardResponse::getStandardResponse(
                    201,
                    "Industry Successfully Updated"
                );
            }else{
                return StandardResponse::getStandardResponse(
                    Response::HTTP_FORBIDDEN,
                    "Not Allowed To Update Industry"
                );
            }
        }catch (\Exception $exception){
            Log::error("Failed to update industry", ['reason' => $exception->getMessage()]);
            return StandardResponse::getStandardResponse(
                500,
                "Failed To Update Industry"
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Industry $industry
     *
     * @return JsonResponse
     */
    public function destroy(Industry $industry)
    {
        if (Auth::user()->can('delete', $industry)) {
            $industry->delete();
            return StandardResponse::getStandardResponse(
                201,
                "Industry Successfully Deleted"
            );
        }
        return StandardResponse::getStandardResponse(
            Response::HTTP_FORBIDDEN,
            "Not Allowed To Delete Industry"
        );
    }
}
