<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/store', StoreController::class);
    Route::apiResource('dates', DateController::class);  
    Route::post('/dates/switch/{date}', [DateController::class,'switch']);
    Route::post('/dates/change/{date}/{user}', [DateController::class,'change']);
    Route::post('/dates/waiting/{date}', [DateController::class,'waiting']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('companies', CompanyController::class);
});
