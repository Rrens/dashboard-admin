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
            $url = 'https://api-berita-indonesia.vercel.app/';
            // dd($_URL);
            $data_from_api = collect(Http::get($_URL)->json());
            dd($data_from_api);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        // $response_body = json_decode($response->getBody());
        // dd($response_body);
        return view('admin.page.verifikasi.merchant', compact('active'));
    }
}
