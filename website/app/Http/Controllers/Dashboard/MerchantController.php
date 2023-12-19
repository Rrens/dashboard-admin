<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MerchantController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        // Merchant Verifikasi dan tidak
        $_URL_VERIFY_AND_NOT = env('API_URL') . 'dashboard/merchant/verify';
        $data_api_verify_and_not = collect(Http::get($_URL_VERIFY_AND_NOT)->json());
        if (!empty($data_api_verify_and_not['data'][0])) {
            $data_verify_and_not = $data_api_verify_and_not['data'];
        } else {
            $data_verify_and_not = null;
        }

        // Pengguna Aktif dan tidak
        $_URL_MERCHANT_ACTIVE_OR_NOT = env('API_URL') . 'dashboard/merchant/check-merchant-active-or-not';
        $data_api_merchant_active_or_not = collect(Http::get($_URL_MERCHANT_ACTIVE_OR_NOT)->json());
        if (!empty($data_api_merchant_active_or_not['data'][0])) {
            $data_merchant_active_or_not = $data_api_merchant_active_or_not['data'];
        } else {
            $data_merchant_active_or_not = null;
        }

        // Rata-rata transaksi merchant berdasarkan periode
        $_URL_AVERAGE_TRANSACTION_PERIODE = env('API_URL') . 'dashboard/merchant/average-transaction-merchant-periode';
        $data_api_average_transaction = collect(Http::get($_URL_AVERAGE_TRANSACTION_PERIODE)->json());
        // dd($data_api_average_transaction['month']);
        if (!empty($data_api_average_transaction['data'])) {
            $data_transaction_merchant_periode = $data_api_average_transaction['data'];
            $data_transaction_month = $data_api_average_transaction['month'];
            $array = [];
            foreach ($data_transaction_month as $value) {
                $array[] = (int) $value;
            }
            $month = implode(', ', $array);

            $totalTransactions = array_map(function ($item) {
                return $item['total_transaction'];
            }, $data_transaction_merchant_periode);

            $totalTransactionsString = implode(', ', $totalTransactions);

            $yearTransaction = array_map(function ($item) {
                return $item['year'];
            }, $data_transaction_merchant_periode);

            $yearTransactionString = implode(', ', $yearTransaction);
        } else {
            $data_transaction_merchant_periode = null;
            $data_transaction_month = null;
        }
        // dd($data_transaction_month);
        return view('admin.page.dashboard.merchant', compact(
            'active',
            'data_verify_and_not',
            'data_merchant_active_or_not',
            'totalTransactionsString',
            'month',
            'yearTransactionString',
        ));
    }

    public function detail($status)
    {
        $active = 'dashboard';
        $_URL = null;
        if ($status == 'verify' || $status == 'not-verify') {
            $_URL = env('API_URL') . 'dashboard/merchant/detail/verify/' . $status;
        } elseif ($status == 'aktif' || $status == 'tidak') {
            $_URL = env('API_URL') . 'dashboard/merchant/detail/active-or-not/' . $status;
            # code...
        } else {
            $_URL = env('API_URL') . 'dashboard/merchant/average-transaction-merchant-per-month/' . $status;
        }

        $data_api = collect(Http::get($_URL)->json());
        if (!empty($data_api['data'][0])) {
            $data = array();
            $data = $data_api['data'];

            $array_is_approve = [];
            foreach ($data_api['data'] as $value) {
                $array_is_approve[] = (int) $value['data'];
            }
            $is_approve = implode(', ', $array_is_approve);

            $array = [];
            if ($status != 'verify' && $status != 'not-verify' && $status != 'aktif' && $status != 'tidak') {
                foreach ($data_api['month'] as $value) {
                    $array[] = json_encode($value['name']);
                    // dd($value['name']);
                }
            } else {
                foreach ($data_api['month'] as $value) {
                    $array[] = (int) $value;
                }
            }
            $month = implode(', ', $array);

            $array_year = [];
            foreach ($data_api['data'] as $value) {
                $array_year[] = (int) $value['year'];
            }
            $year = implode(', ', $array_year);
        } else {
            $data = null;
        }
        return view('admin.page.dashboard.detail.merchant', compact(
            'active',
            'status',
            'is_approve',
            'month',
            'year'
        ));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'id' => 'required',
            'email' => 'required|email',
            'telp' => 'required',
            'address' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'id_card' => 'required',
            'npwp' => 'required',
            'last_login' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name,
            'id' => $request->id,
            'email' => $request->email,
            'telp' => $request->telp,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'id_card' => $request->id_card,
            'npwp' => $request->npwp,
            'last_login' => $request->last_login,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/update';
        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            dd($errorMessage);
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function print_verify($approve)
    {
        $_URL_MERCHANT_ACTIVE_OR_NOT = env('API_URL') . 'dashboard/merchant/data-verify';
        $data_api_merchant_active_or_not = collect(Http::get($_URL_MERCHANT_ACTIVE_OR_NOT)->json());
        if (!empty($data_api_merchant_active_or_not['data'][0])) {
            $data = array();
            if ($approve == 'verify') {
                if (!empty($data_api_merchant_active_or_not['data'][0])) {
                    $data = $data_api_merchant_active_or_not['data'];
                } else {
                    $data = null;
                }
            } else {
                if (!empty($data_api_merchant_active_or_not['data_not_active'][0])) {
                    $data = $data_api_merchant_active_or_not['data_not_active'];
                } else {
                    $data = null;
                }
            }
        } else {
            $data = null;
        }
        return view('admin.page.dashboard.grafik.print.merchant', compact('data'));
    }

    public function print_active_or_not($status)
    {
        // dd($data);
        $_URL_MERCHANT_ACTIVE_OR_NOT = env('API_URL') . 'dashboard/merchant/data-merchant-active';
        $data_api_merchant_active_or_not = collect(Http::get($_URL_MERCHANT_ACTIVE_OR_NOT)->json());
        if ($status == 'active') {
            if (!empty($data_api_merchant_active_or_not['data'][0])) {
                $data = $data_api_merchant_active_or_not['data'];
            } else {
                $data = null;
            }
        } else {
            if (!empty($data_api_merchant_active_or_not['data_not_active'][0])) {
                $data = $data_api_merchant_active_or_not['data_not_active'];
            } else {
                $data = null;
            }
        }
        return view('admin.page.dashboard.grafik.print.merchant', compact('data'));
    }

    public function print_average_transaction($month, $year)
    {
        $_URL_AVERAGE_TRANSACTION = env('API_URL') . 'dashboard/merchant/data-average-transaction-merchant-periode/' . $month . '/' . $year;
        $data_average_transaction = collect(Http::get($_URL_AVERAGE_TRANSACTION)->json());
        if (!empty($data_average_transaction['data'][0])) {
            $data = array();
            $data = $data_average_transaction['data'];
        } else {
            $data = null;
        }
        return view('admin.page.dashboard.grafik.print.merchant-average', compact('data'));
    }

    public function updateVerifyOrNot(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|string',
            'id_edit' => 'required',
            'email_edit' => 'required|email',
            'telp_edit' => 'required|numeric',
            'address_edit' => 'required',
            'city_edit' => 'required|string',
            'province_edit' => 'required|string',
            'id_card_edit' => 'required|numeric',
            'npwp_edit' => 'required',
            'last_login_edit' => 'required',
            'picture_edit' => 'image|mimes:png,jpg,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit,
            'id' => $request->id_edit,
            'email' => $request->email_edit,
            'telp' => $request->telp_edit,
            'address' => $request->address_edit,
            'city' => $request->city_edit,
            'province' => $request->province_edit,
            'id_card' => $request->id_card_edit,
            'npwp' => $request->npwp_edit,
            'last_login' => $request->last_login_edit,
            'image' => $request->picture_edit,
        ];

        // $formData = new \GuzzleHttp\Psr7\MultipartStream([
        //     [
        //         'name'     => 'image',
        //         'contents' => fopen($request->file('picture_edit')->path(), 'r'),
        //     ],
        // ]);

        $_URL = env('API_URL') . 'dashboard/merchant/update-verify';

        try {
            $response = Http::withHeaders([
                // 'Content-Type' => 'multipart/form-data',
            ])->post($_URL, [
                $data,
            ]);
        } catch (\Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function updateActiveOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|string',
            'id_edit' => 'required',
            'email_edit' => 'required|email',
            'telp_edit' => 'required|numeric',
            'address_edit' => 'required',
            'city_edit' => 'required|string',
            'province_edit' => 'required|string',
            'id_card_edit' => 'required|numeric',
            'npwp_edit' => 'required',
            'last_login_edit' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit,
            'id' => $request->id_edit,
            'email' => $request->email_edit,
            'telp' => $request->telp_edit,
            'address' => $request->address_edit,
            'city' => $request->city_edit,
            'province' => $request->province_edit,
            'id_card' => $request->id_card_edit,
            'npwp' => $request->npwp_edit,
            'last_login' => $request->last_login_edit,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/update-active-or-not';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {
            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            dd($errorMessage);
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function updateAvgTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|string',
            'id_edit' => 'required',
            'email_edit' => 'required|email',
            'telp_edit' => 'required|numeric',
            'address_edit' => 'required',
            'city_edit' => 'required|string',
            'province_edit' => 'required|string',
            'id_card_edit' => 'required|numeric',
            'npwp_edit' => 'required',
            'last_login_edit' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit,
            'id' => $request->id_edit,
            'email' => $request->email_edit,
            'telp' => $request->telp_edit,
            'address' => $request->address_edit,
            'city' => $request->city_edit,
            'province' => $request->province_edit,
            'id_card' => $request->id_card_edit,
            'npwp' => $request->npwp_edit,
            'last_login' => $request->last_login_edit,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/update-average';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {
            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function DestroyVerifyOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/destroy-verify';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function DestroyActiveOrNot(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/destroy-active';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function DestroyAvgTransaction(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/destroy-average';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }
}
