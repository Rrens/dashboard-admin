<?php

use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\Dashboard\IklantController;
use App\Http\Controllers\Dashboard\MerchantController as DashboardMerchantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Verifikasi\IklanController;
use App\Http\Controllers\Verifikasi\MerchantController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'dashboard/merchant');

Route::group([
    'prefix' => 'dashboard',
], function () {
    Route::group([
        'prefix' => 'merchant',
    ], function () {
        Route::get('', [DashboardMerchantController::class, 'index'])->name('merchant.dashboard');
        Route::post('/update-verify-or-not', [DashboardMerchantController::class, 'updateVerifyOrNot'])->name('merchant.update-verify');
        Route::post('/update-average-detail', [DashboardMerchantController::class, 'updateAvgTransaction'])->name('merchant.update-average');
        Route::post('/update-active-or-not', [DashboardMerchantController::class, 'updateActiveOrNot'])->name('merchant.update-active-or-not');
    });
    Route::get('iklan', [IklantController::class, 'index'])->name('iklan.dashboard');
    // Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group([
    'prefix' => 'admin-management',
], function () {
    Route::get('', [AdminManageController::class, 'index'])->name('admin.index');
    Route::post('', [AdminManageController::class, 'store'])->name('admin.store');
    Route::post('update', [AdminManageController::class, 'update'])->name('admin.update');
    Route::post('delete', [AdminManageController::class, 'delete'])->name('admin.delete');
});

Route::group([
    'prefix' => 'verifikasi',
], function () {
    Route::get('merchant', [MerchantController::class, 'index'])->name('verifikasi.merchant.index');
    Route::get('iklan', [IklanController::class, 'index'])->name('verifikasi.iklan.index');
});
