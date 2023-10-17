<?php

use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Verifikasi\IklanController;
use App\Http\Controllers\Verifikasi\MerchantController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'dashboard', 301);

Route::group([
    'prefix' => 'dashboard',
], function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group([
    'prefix' => 'admin-management',
], function () {
    Route::get('', [AdminManageController::class, 'index'])->name('admin.index');
});

Route::group([
    'prefix' => 'verifikasi',
], function () {
    Route::get('merchant', [MerchantController::class, 'index'])->name('verifikasi.merchant.index');
    Route::get('iklan', [IklanController::class, 'index'])->name('verifikasi.iklan.index');
});
