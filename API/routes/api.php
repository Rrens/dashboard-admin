<?php

use App\Http\Controllers\API\Dashboard\AdsController as DashboardAdsController;
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
        Route::post('update', [DashboardMerchantController::class, 'update']);
        Route::get('verify', [DashboardMerchantController::class, 'data_verify_merchant_and_not']);
        Route::get('data-verify/{status}/{month}/{year}', [DashboardMerchantController::class, 'data_verify_merchant']);
        Route::get('check-merchant-active-or-not', [DashboardMerchantController::class, 'data_active_merchant_and_not']);
        Route::get('data-merchant-active/{status}/{month}/{year}', [DashboardMerchantController::class, 'data_active_merchant']);
        Route::get('average-transaction-merchant-periode', [DashboardMerchantController::class, 'avgTransactionMerchantPerPeriod']);
        Route::get('data-average-transaction-merchant-periode/{month}/{year}', [DashboardMerchantController::class, 'dataAvgTransactionMerchantPerPeriod']);
        Route::get('merchant-detail/{id}', [DashboardMerchantController::class, 'merchant_detail']);
        Route::post('update-verify', [DashboardMerchantController::class, 'update_verify']);
        Route::post('update-average', [DashboardMerchantController::class, 'update_average']);
        Route::post('update-active-or-not', [DashboardMerchantController::class, 'update_active_or_not']);
        Route::post('destroy-verify', [DashboardMerchantController::class, 'destroy_verify']);
        Route::post('destroy-average', [DashboardMerchantController::class, 'destroy_average']);
        Route::post('destroy-active', [DashboardMerchantController::class, 'destroy_active']);
        Route::group([
            'prefix' => 'detail',
        ], function () {
            Route::get('verify/{status}', [DashboardMerchantController::class, 'verifyDetailPerMonth']);
            Route::get('active-or-not/{status}', [DashboardMerchantController::class, 'verifyActiveOrNotPerMonth']);
        });
        // Route::get('/test-destroy/{id}', [DashboardMerchantController::class, 'test']);
    });

    Route::group([
        'prefix' => 'iklan'
    ], function () {
        Route::post('update', [DashboardAdsController::class, 'update']);
        Route::get('verify', [DashboardAdsController::class, 'data_verify_ads_and_not']);
        Route::get('data-verify/{status}/{month}/{year}', [DashboardAdsController::class, 'data_verify_ads']);
        Route::get('average-favorite-ads', [DashboardAdsController::class, 'favorite_ads_per_categories']);
        Route::get('data-average-favorite-ads/{status}/{month}/{year}', [DashboardAdsController::class, 'data_favorite_ads_per_categories']);
        Route::get('rating-ads-periode', [DashboardAdsController::class, 'rating_ads_per_periode']);
        Route::get('data-rating-ads-periode/{category}', [DashboardAdsController::class, 'data_rating_ads_per_periode']);
        Route::get('ads-detail/{id}', [DashboardAdsController::class, 'ads_detail']);
        Route::post('update-verify', [DashboardAdsController::class, 'update_verify']);
        Route::post('update-ads-favorite', [DashboardAdsController::class, 'update_ads_favorite']);
        Route::post('update-count-rating', [DashboardAdsController::class, 'update_count_rating']);
        Route::post('destroy-count-rating', [DashboardAdsController::class, 'destroy_count_rating']);
        Route::post('destroy-favorite-ads', [DashboardAdsController::class, 'destroy_favorite_ads']);
        Route::post('destroy-verify', [DashboardAdsController::class, 'destroy_verify']);

        Route::group([
            'prefix' => 'detail',
        ], function () {
            Route::get('verify/{status}', [DashboardAdsController::class, 'ads_verify_per_month']);
            Route::get('favorite/{status}', [DashboardAdsController::class, 'ads_favorite_per_month']);
            Route::get('rating-periode/{status}', [DashboardAdsController::class, 'ads_rating_ads_per_category']);
        });
    });
});
