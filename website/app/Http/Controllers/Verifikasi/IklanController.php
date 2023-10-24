<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IklanController extends Controller
{
    public function index()
    {
        $active = 'verifikasi iklan';
        try {
            $_URL = env('API_URL') . 'verify/ads';
            $data_from_api = collect(Http::get($_URL)->json());
            // dd($data_from_api['data'][0]);
            if (!empty($data_from_api['data'][0])) {
                $data = $data_from_api['data'];
            } else {
                $data = null;
            }
        } catch (Exception $error) {
            dd($error->getMessage());
        }
        return view('admin.page.verifikasi.iklan', compact('active', 'data'));
    }
}
