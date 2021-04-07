<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIndustryRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $industries = Industry::all();
        return StandardResponse::getStandardResponse(
            200,
            $industries
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function show(Industry $industry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function edit(Industry $industry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Industry  $industry
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateIndustryRequest $request, Industry $industry): \Illuminate\Http\JsonResponse
    {
        try {
            $industry->name = $request->get('name');
            $industry->save();
            return StandardResponse::getStandardResponse(
                201,
                "Industry Successfully Updated"
            );
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
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Industry $industry)
    {

    }
}
