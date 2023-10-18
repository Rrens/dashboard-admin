<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MerchantController extends Controller
{
    public function index()
    {
        $active = 'verifikasi merchant';
        try {
            $_URL = env('API_URL') . 'verify/merchant';
            $data_from_api = collect(Http::get($_URL)->json());
            $data = $data_from_api['data'];
            // dd($data);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        // $response_body = json_decode($response->getBody());
        // dd($response_body);
        return view('admin.page.verifikasi.merchant', compact('active', 'data'));
    }
}
