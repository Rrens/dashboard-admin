<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MerchantController extends Controller
{
    public function index()
    {
        $active = 'verifikasi merchant';
        try {
            $_URL = env('API_URL') . 'verify/merchant';
            $data_from_api = collect(Http::get($_URL)->json());
            if (!empty($data_from_api['data'][0])) {
                $data = $data_from_api['data'];
                $data_categories = $data_from_api['categories'];
            } else {
                $data = null;
                $data_categories = null;
            }
        } catch (Exception $error) {
            dd($error->getMessage());
        }
        // dd($data_categories);

        return view('admin.page.verifikasi.merchant', compact('active', 'data', 'data_categories'));
    }
};
