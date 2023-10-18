<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        $active = 'verifikasi iklan';
        return view('admin.page.verifikasi.iklan', compact('active'));
    }
}
