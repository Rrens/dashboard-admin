<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
