<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\CompaniesController;
use \App\Http\Controllers\IndustryController;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\FeatureController;
use \App\Http\Controllers\UserDataController;
use \App\Http\Controllers\EducationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/test', [AuthController::class, 'test']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/company/attached", [CompaniesController::class, "showAttachedToUser"]);
    Route::resource("/company", CompaniesController::class);
    Route::put("/company/{company}/attach", [CompaniesController::class, "attachUserToCompany"]);
    Route::put("/company/{company}/detach", [CompaniesController::class, "detachUserFromCompany"]);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/industry", IndustryController::class);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/project", ProjectController::class);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/feature", FeatureController::class);
    Route::put("/feature/{feature}/attachTag/{tag}", [FeatureController::class, "attachTag"]);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/userData", UserDataController::class);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/education", EducationController::class);
    Route::put("/education/{education}/attach", [EducationController::class, "attachUserWithEducation"]);
    Route::put("/education/{education}/detach", [EducationController::class, "detachUserWithEducation"]);
});
