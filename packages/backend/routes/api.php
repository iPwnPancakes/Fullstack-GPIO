<?php

use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\FrontendController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('frontend')->group(function () {
        Route::get('ping/{id}', [FrontendController::class, 'ping']);
        Route::get('getConnectionInfo/{id}', [FrontendController::class, 'getConnectionInformation']);
        Route::post('set_power', [FrontendController::class, 'setPower']);
        Route::get('getPower/{id}', [FrontendController::class, 'getPower']);
    });

    Route::prefix('devices')->group(function () {
        Route::post('check_in', [DeviceController::class, 'check_in']);
        Route::get('check_out', [DeviceController::class, 'check_out']);
    });
});
