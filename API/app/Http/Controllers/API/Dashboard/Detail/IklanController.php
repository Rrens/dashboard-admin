<?php

namespace App\Http\Controllers\API\Dashboard\Detail;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IklanController extends Controller
{
    public function ads_verify_per_month($status)
    {
        $data_category = SubCategory::all();
        $value = null;

        if ($status == 'verify') {
            $value = 'approve';
        }
        if ($status == 'not verify') {
            $value = 'not_approve';
        }

        $month = Ads::groupBy('month')
            ->orderBy('month', 'asc')
            ->whereNull('deleted_at')
            ->where('is_approve', $value)
            ->pluck('month');
        // dd($status);

        $data = DB::table('ads')
            ->select(
                '*',
                'year',
                'month',
                DB::raw('SUM(CASE WHEN is_approve = "' . $value . '" THEN 1 ELSE 0 END) as data')
            )
            ->groupBy('month')
            ->whereNull('deleted_at')
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

    public function ads_favorite_per_month($status)
    {
        $data_category = SubCategory::all();
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        // Menggunakan metode array_search untuk mencari indeks nama bulan
        $monthNumber = array_search($status, $monthNames) + 1;

        $averageRating = Ads::average('rating');

        $month = Ads::groupBy('month')
            ->where('rating', '>', $averageRating)
            ->where('category_id', $status)
            ->groupBy('month')
            ->where('category_id', $status)
            ->whereNull('deleted_at')
            ->orderBy('month', 'asc')
            ->pluck('month');


        $data = DB::table('ads')
            ->select(
                'rating',
                'year',
                'month',
                // DB::raw('COUNT(CASE WHEN rating > "' . $averageRating . '" THEN 1 ELSE 0 END) as data')
                DB::raw('COUNT(rating) as data')
            )
            // ->having(DB::raw('COUNT(rating)'), '>', $averageRating)
            // ->groupBy('year', 'month', 'rating')
            ->where('rating', '>', $averageRating)
            ->groupBy('month')
            ->where('category_id', $status)
            ->whereNull('deleted_at')
            ->orderBy('month', 'asc')
            ->get();

        // return response()->json($data);
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

    public function ads_rating_ads_per_category($status)
    {
        $data_category = SubCategory::all();
        $monthNumbers = [
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'Mei' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Ags' => 8,
            'Sep' => 9,
            'Okt' => 10,
            'Nov' => 11,
            'Des' => 12,
        ];

        $selectedMonth = $status;
        $monthNumber = $monthNumbers[$selectedMonth];
        // return response()->json($monthNumber);

        $averageRating = Ads::average('rating');

        $array_category_id = array();

        $data = DB::table('ads')
            ->select(
                'ads.year',
                'ads.category_id',
                'ads.month',
                'ads.rating',
                // DB::raw('SUM(CASE WHEN rating > "' . $averageRating . '" THEN 1 ELSE 0 END) as data')
                DB::raw('COUNT(rating) as data')
            )
            ->join('transaction as t', 't.ads_id', 'ads.id')
            ->groupBy('ads.category_id')
            ->where('ads.rating', '>', $averageRating)
            ->whereNull('ads.deleted_at')
            ->where('ads.month', $monthNumber)
            ->orderBy('ads.category_id', 'asc')
            ->get();

        foreach ($data as $key) {
            array_push($array_category_id, $key->category_id);
        }

        $month = Categories::whereIn('id', $array_category_id)
            ->whereNull('deleted_at')
            ->pluck('name');

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
