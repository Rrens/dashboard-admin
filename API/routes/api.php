<?php

use App\Http\Controllers\API\Dashboard\MerchantController as DashboardMerchantController;
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

    Route::group([
        'prefix' => 'merchant',
    ], function () {
        Route::get('', [MerchantController::class, 'index']);
        Route::post('detail', [MerchantController::class, 'detail']);
        Route::post('change-approve', [MerchantController::class, 'change_approve']);
    });

    Route::group([
        'prefix' => 'ads'
    ], function () {
        Route::get('', [AdsController::class, 'index']);
        Route::post('change-approve',  [AdsController::class, 'change_approve']);
    });
});

Route::group([
    'prefix' => 'dashboard'
], function () {
    Route::group([
        'prefix' => 'merchant'
    ], function () {
        Route::get('verify', [DashboardMerchantController::class, 'data_verify_merchant_and_not']);
        Route::get('data-verify', [DashboardMerchantController::class, 'data_verify_merchant']);
        Route::get('check-merchant-active-or-not', [DashboardMerchantController::class, 'data_active_merchant_and_not']);
        Route::get('data-merchant-active', [DashboardMerchantController::class, 'data_active_merchant']);
        Route::get('average-transaction-merchant-periode', [DashboardMerchantController::class, 'avgTransactionMerchantPerPeriod']);
        Route::get('data-average-transaction-merchant-periode/{month}/{year}', [DashboardMerchantController::class, 'dataAvgTransactionMerchantPerPeriod']);
    });
});
