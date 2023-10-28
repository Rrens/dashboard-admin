<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function data_verify_merchant_and_not()
    {
        $data = Merchant::select(DB::raw('
                SUM(CASE WHEN is_approve = "approve" THEN 1 ELSE 0 END) as approve,
                SUM(CASE WHEN is_approve = "not_approve" THEN 1 ELSE 0 END) as not_approve
            '))
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function data_verify_merchant()
    {
        $data = Merchant::where('is_approve', 'approve')->get();
        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function data_active_merchant_and_not()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $data = Merchant::selectRaw('
                SUM(CASE WHEN last_login >= ? THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN last_login < ? THEN 1 ELSE 0 END) as not_active
            ', [$threeMonthsAgo, $threeMonthsAgo])
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function data_active_merchant()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Merchant yang aktif dalam 3 bulan terakhir
        $data = Merchant::whereNotNull('last_login')
            ->whereDate('last_login', '>=', $threeMonthsAgo)
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function avgTransactionMerchantPerPeriod()
    {

        $month = Transaction::groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('month');

        $data = Transaction::select(
            DB::raw('year'),
            DB::raw('month'),
            DB::raw('SUM(total_transaction) as total_transaction')
        )
            ->groupBy('year', 'month')
            ->orderBy('month', 'asc')
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
                'month' => $month,
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function dataAvgTransactionMerchantPerPeriod($month, $year)
    {
        $data = Transaction::where('month', $month)
            ->where('year', $year)
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }
}
