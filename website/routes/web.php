<?php

use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\IklanController as DashboardIklanController;
use App\Http\Controllers\Dashboard\MerchantController as DashboardMerchantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Verifikasi\IklanController;
use App\Http\Controllers\Verifikasi\MerchantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('cek', function () {
    $_URL = 'http://127.0.0.1:5000/api/sales-data';

    $data = collect(Http::get($_URL)->json());
    dd($data);
});
Route::redirect('/', 'dashboard/merchant');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('post-login', [AuthController::class, 'post_login'])->name('post-login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'forgot_post'])->name('forgot-post-password');

Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['auth', 'role:admin,superadmin'],
    ''
], function () {
    Route::group([
        'prefix' => 'merchant',
    ], function () {
        Route::get('', [DashboardMerchantController::class, 'index'])->name('merchant.dashboard');
        Route::get('detail/{status}', [DashboardMerchantController::class, 'detail'])->name('merchant.detail');
        Route::post('', [DashboardMerchantController::class, 'update'])->name('merchant.update');
        Route::post('update-verify-or-not', [DashboardMerchantController::class, 'updateVerifyOrNot'])->name('merchant.update-verify');
        Route::post('update-average-detail', [DashboardMerchantController::class, 'updateAvgTransaction'])->name('merchant.update-average');
        Route::post('update-active-or-not', [DashboardMerchantController::class, 'updateActiveOrNot'])->name('merchant.update-active-or-not');
        Route::post('destroy-verify-or-not', [DashboardMerchantController::class, 'DestroyVerifyOrNot'])->name('merchant.destroy-verify');
        Route::post('destroy-active-or-not', [DashboardMerchantController::class, 'DestroyActiveOrNot'])->name('merchant.destroy-active');
        Route::post('destroy-average-detail', [DashboardMerchantController::class, 'DestroyAvgTransaction'])->name('merchant.destroy-average');
        Route::get('print-verify/{approve}', [DashboardMerchantController::class, 'print_verify'])->name('print.verify-merchant');
        Route::get('print-active-or-not/{status}', [DashboardMerchantController::class, 'print_active_or_not'])->name('print.active-merchant');
        Route::get('print-average-transaction/{month}/{year}', [DashboardMerchantController::class, 'print_average_transaction'])->name('print.average-merchant');
    });

    Route::group([
        'prefix' => 'iklan',
    ], function () {
        Route::get('', [DashboardIklanController::class, 'index'])->name('iklan.dashboard');
        Route::get('detail/{status}', [DashboardIklanController::class, 'detail'])->name('ads.detail');
        Route::post('update', [DashboardIklanController::class, 'update'])->name('ads.update');
        Route::post('update-verify-or-not', [DashboardIklanController::class, 'updateVerifyOrNot'])->name('ads.update-verify');
        Route::post('update-ads-favorite', [DashboardIklanController::class, 'updateAdsFavorite'])->name('ads.update-favorite');
        Route::post('update-count-rating', [DashboardIklanController::class, 'updateCountRating'])->name('ads.update-count-rating');
        Route::post('delete-count-rating', [DashboardIklanController::class, 'deleteCountRating'])->name('ads.delete-count-rating');
        Route::post('delete-favorite-ads', [DashboardIklanController::class, 'deleteFavoriteAds'])->name('ads.delete-favorite-ads');
        Route::post('delete-verify', [DashboardIklanController::class, 'deleteVerify'])->name('ads.delete-verify');
        Route::get('print-rating/{month}', [DashboardIklanController::class, 'print_rating_ads'])->name('print.rating-ads');
        Route::get('print-verify/{status}', [DashboardIklanController::class, 'print_verify_ads'])->name('print.rating-ads');
        Route::get('print-ads-favorite/{category}', [DashboardIklanController::class, 'print_ads_favorite'])->name('print.rating-ads');
    });
});

Route::group([
    'prefix' => 'admin-management',
    'middleware' => ['auth', 'role:superadmin,admin'],
], function () {
    Route::group([
        'middleware' => ['auth', 'role:superadmin'],
    ], function () {
        Route::get('', [AdminManageController::class, 'index'])->name('admin.index');
        Route::post('', [AdminManageController::class, 'store'])->name('admin.store');
        Route::post('update', [AdminManageController::class, 'update'])->name('admin.update');
        Route::post('delete', [AdminManageController::class, 'delete'])->name('admin.delete');
        Route::post('update-password', [AdminManageController::class, 'update_password'])->name('admin.update-password');
    });

    Route::group([
        'prefix' => 'profile'
    ], function () {
        Route::get('', [AdminManageController::class, 'profile'])->name('admin.profile');
        Route::post('store-profile', [AdminManageController::class, 'profile_store'])->name('profile.store');
    });
});

Route::group([
    'prefix' => 'verifikasi',
    'middleware' => ['auth', 'role:admin,superadmin'],
], function () {
    Route::get('merchant', [MerchantController::class, 'index'])->name('verifikasi.merchant.index');
    Route::get('iklan', [IklanController::class, 'index'])->name('verifikasi.iklan.index');
});

Route::get('home', function () {

    $data = Auth::user();
    $active = 'home';
    return view('admin.page.home', compact('data', 'active'));
})->name('home')->middleware('auth', 'role:admin,superadmin');
