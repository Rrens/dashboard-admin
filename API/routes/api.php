<?php

use App\Http\Controllers\API\Verify\AdsController;
use App\Http\Controllers\API\Verify\MerchantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([
    'prefix' => 'verify',
], function () {
    Route::get('merchant', [MerchantController::class, 'index']);
    Route::post('change-approve', [MerchantController::class, 'change_approve']);
    Route::get('ads', [AdsController::class, 'index']);
});
