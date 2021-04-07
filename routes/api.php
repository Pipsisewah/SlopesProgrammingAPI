<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\CompaniesController;
use \App\Http\Controllers\IndustryController;

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
Route::get('/test2', [AuthController::class, 'test']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/company", CompaniesController::class);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/industry", IndustryController::class);
});
