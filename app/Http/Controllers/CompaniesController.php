<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Responses\StandardResponse;
use App\Models\Company;
use App\Models\Industry;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return StandardResponse::getStandardResponse(
            200,
            Company::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateCompanyRequest $request
     *
     */
    public function create(CreateCompanyRequest $request)
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
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyRequest $request): JsonResponse
    {
        try {
            $company = new Company($request->all());
            $company->createdBy()->associate(Auth::id());
            $company->industry()->associate(Industry::find($request->get('industry')));
            $company->save();

            return StandardResponse::getStandardResponse(
                201,
                "Company Successfully Created"
            );
        }catch (\Exception $exception){
            return StandardResponse::getStandardResponse(
                500,
                "Failed To Create The New Company"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $company = Company::find($id);
        if (Auth::user()->can('view', $company)) {
            return StandardResponse::getStandardResponse(200, "Company Information", ['company' => $company]);
        }
        return StandardResponse::getStandardResponse(Response::HTTP_FORBIDDEN, "Unable to get company information");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function edit($id)
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
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $company = Company::find($id);
            if (Auth::user()->can('update', $company)) {
                $company->fill($request->all());
                $industry = Industry::find($request->get('industry'));
                $company->industry()->associate($industry);
                $company->save();

                return StandardResponse::getStandardResponse(
                    201,
                    "Company Successfully Updated"
                );
            }
        }catch (\Exception $exception){
            Log::error("Failed to update company", ['reason' => $exception->getMessage()]);
            return StandardResponse::getStandardResponse(
                500,
                "Failed To Update Company"
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        if (Auth::user()->can('delete', $company)) {
            $company->delete();
            return StandardResponse::getStandardResponse(
                201,
                "Company Successfully Deleted"
            );
        }
        return StandardResponse::getStandardResponse(
            Response::HTTP_FORBIDDEN,
            "Failed To Delete Company"
        );
    }
}
