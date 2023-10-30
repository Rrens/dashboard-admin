<?php

use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Verifikasi\IklanController;
use App\Http\Controllers\Verifikasi\MerchantController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'dashboard/merchant');

Route::group([
    'prefix' => 'dashboard',
], function () {
    Route::get('merchant', [MerchantController::class, 'dashboard_index'])->name('merchant.dashboard');
    Route::get('iklan', [IklanController::class, 'dashboard_index'])->name('iklan.dashboard');
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
