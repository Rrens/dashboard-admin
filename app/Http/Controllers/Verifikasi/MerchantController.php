<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $active = 'verifikasi merchant';
        return view('admin.page.verifikasi.merchant', compact('active'));
    }
}
