<?php

namespace App\Http\Controllers\API\Dashboard\Detail;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\SubCategory;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function data_dashboard_merchant_category($month, $category)
    {
        $data = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->join('categories as c', 'c.id', '=', 'm.category_id')
            ->join('sub_category as sc', 'c.id', '=', 'sc.category_id')
            ->select(
                DB::raw('transaction.id as id'),
                DB::raw('m.category_id as category_id'),
                DB::raw('m.id as merchant_id'),
                DB::raw('transaction.ads_id as ads_id'),
                DB::raw('transaction.month as month'),
                DB::raw('transaction.year as year'),
                DB::raw('transaction.total_transaction as total_transaction'),
            )
            ->where(function ($query) use ($month) {
                $query->where('transaction.month', $month)
                    ->where('transaction.year', 2023);
            })
            ->where('transaction.month', $month)
            // ->groupBy('sc.name')
            ->orderBy('sc.name', 'asc')
            ->where('sc.name', $category)
            ->whereNull('m.deleted_at')
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

    public function verifyDetailPerMonth($status)
    {
        $data_category = SubCategory::all();

        if ($status == 'verify') {
            $status = 'approve';
        }

        if ($status == 'not-verify') {
            $status = 'not_approve';
        }

        $month = Merchant::groupBy('month')
            ->whereNull('deleted_at')
            ->where('is_approve', $status)
            ->orderBy('month', 'asc')
            ->where('year', 2023)
            ->pluck('month');

        $data = DB::table('merchants')
            ->select(
                'year',
                'month',
                // DB::raw('COUNT(CASE WHEN is_approve = "' . $status . '" THEN 1 ELSE 0 END) as data')
                DB::raw('COUNT(is_approve) as data')
            )
            ->where('is_approve', $status)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->whereNull('deleted_at')
            ->where('year', 2023)
            ->get();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
                'month' => $month,
                'categories' => $data_category
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }

    public function verifyActiveOrNotPerMonth($status)
    {
        $data_category = SubCategory::all();

        $data = null;
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        $array_month = array();
        // dd($threeMonthsAgo);
        if ($status == 'aktif') {
            $data = DB::table('merchants')
                ->select(
                    'year',
                    'month',
                    DB::raw(
                        'COUNT(last_login) as data'
                    )
                )
                ->whereDate('last_login', '>=', $threeMonthsAgo)
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->whereNull('deleted_at')
                ->where('year', 2023)
                ->get();

            // $month = Merchant::groupBy('month')
            //     ->whereIn('last_login', $array_month)
            //     ->orderBy('month', 'asc')
            //     ->whereNull('deleted_at')
            //     ->pluck('month');
        }

        if ($status == 'tidak') {
            $data = DB::table('merchants')
                ->select(
                    'year',
                    'month',
                    DB::raw(
                        'COUNT(last_login) as data'
                    )
                )
                ->whereDate('last_login', '<', $threeMonthsAgo)
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->whereNull('deleted_at')
                ->where('year', 2023)
                ->get();



            // $month = Merchant::groupBy('month')
            //     ->whereIn('last_login', $array_month)
            //     ->orderBy('month', 'asc')
            //     ->whereNull('deleted_at')
            //     ->pluck('month');

        }

        // return response()->json($data->pluck('month'));
        foreach ($data as $item) {
            array_push($array_month, $item->month);
        }

        $month = $data->pluck('month');

        // dd($data);


        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
                'month' => $month,
                'categories' => $data_category,
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
