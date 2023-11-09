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
        // dd($data_average_transaction);
        if (!empty($data_average_transaction['data'][0])) {
            $data = array();
            $data = $data_average_transaction['data'];
        } else {
            $data = null;
        }
        // dd($data);
        return view('admin.page.dashboard.grafik.print.merchant-average', compact('data'));
    }

    public function updateVerifyOrNot(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name_edit_verify' => 'required|string',
            'id_edit_verify' => 'required',
            'email_edit_verify' => 'required|email',
            'telp_edit_verify' => 'required|numeric',
            'address_edit_verify' => 'required',
            'city_edit_verify' => 'required|string',
            'province_edit_verify' => 'required|string',
            'id_card_edit_verify' => 'required|numeric',
            'npwp_edit_verify' => 'required',
            'last_login_edit_verify' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_verify,
            'id' => $request->id_edit_verify,
            'email' => $request->email_edit_verify,
            'telp' => $request->telp_edit_verify,
            'address' => $request->address_edit_verify,
            'city' => $request->city_edit_verify,
            'province' => $request->province_edit_verify,
            'id_card' => $request->id_card_edit_verify,
            'npwp' => $request->npwp_edit_verify,
            'last_login' => $request->last_login_edit_verify,
        ];

        $_URL = env('API_URL') . 'dashboard/merchant/update-verify';

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

    public function updateActiveOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit_active_or_not' => 'required|string',
            'id_edit_active_or_not' => 'required',
            'email_edit_active_or_not' => 'required|email',
            'telp_edit_active_or_not' => 'required|numeric',
            'address_edit_active_or_not' => 'required',
            'city_edit_active_or_not' => 'required|string',
            'province_edit_active_or_not' => 'required|string',
            'id_card_edit_active_or_not' => 'required|numeric',
            'npwp_edit_active_or_not' => 'required',
            'last_login_edit_active_or_not' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_active_or_not,
            'id' => $request->id_edit_active_or_not,
            'email' => $request->email_edit_active_or_not,
            'telp' => $request->telp_edit_active_or_not,
            'address' => $request->address_edit_active_or_not,
            'city' => $request->city_edit_active_or_not,
            'province' => $request->province_edit_active_or_not,
            'id_card' => $request->id_card_edit_active_or_not,
            'npwp' => $request->npwp_edit_active_or_not,
            'last_login' => $request->last_login_edit_active_or_not,
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
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function updateAvgTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit_average_detail' => 'required|string',
            'id_edit_average_detail' => 'required',
            'email_edit_average_detail' => 'required|email',
            'telp_edit_average_detail' => 'required|numeric',
            'address_edit_average_detail' => 'required',
            'city_edit_average_detail' => 'required|string',
            'province_edit_average_detail' => 'required|string',
            'id_card_edit_average_detail' => 'required|numeric',
            'npwp_edit_average_detail' => 'required',
            'last_login_edit_average_detail' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_average_detail,
            'id' => $request->id_edit_average_detail,
            'email' => $request->email_edit_average_detail,
            'telp' => $request->telp_edit_average_detail,
            'address' => $request->address_edit_average_detail,
            'city' => $request->city_edit_average_detail,
            'province' => $request->province_edit_average_detail,
            'id_card' => $request->id_card_edit_average_detail,
            'npwp' => $request->npwp_edit_average_detail,
            'last_login' => $request->last_login_edit_average_detail,
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
