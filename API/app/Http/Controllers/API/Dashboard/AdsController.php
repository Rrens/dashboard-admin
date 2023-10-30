<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function data_verify_ads_and_not()
    {
        $data = Ads::select(DB::raw('
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

    public function data_verify_ads()
    {
        $data = Ads::with('merchant')->where('is_approve', 'approve')->get();
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

    public function favorite_ads_per_categories()
    {
        $averageRating = Ads::average('rating');

        $data = DB::table('ads as ad')
            ->join('categories as ct', 'ct.id', '=', 'ad.category_id')
            ->join('merchants as mc', 'mc.id', '=', 'ad.merchant_id')
            ->where('ad.rating', '>', $averageRating)
            ->select(
                'ad.id as id_ads',
                'ad.name as name_ads',
                'ct.name as name_category',
                'ad.merchant_id',
                'ad.category_id',
                'ad.category_id',
                'mc.city',
                'mc.province',
                'ad.description',
                'ad.notes',
                'ad.price',
                'ad.picture',
                'ad.count_order',
                'ad.rating',
                'ad.count_view',
                DB::raw('AVG(ad.rating) as average_rating')
            )
            ->groupBy('ad.category_id')
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

    public function data_favorite_ads_per_categories($id)
    {
        $data = Ads::with('merchant')
            ->where('category_id', $id)
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

    public function rating_ads_per_periode()
    {
        $averageRating = Ads::average('rating');

        $data = DB::table('ads as ad')
            ->join('categories as ct', 'ct.id', '=', 'ad.category_id')
            ->join('merchants as mc', 'mc.id', '=', 'ad.merchant_id')
            ->where('ad.rating', '>', $averageRating)
            ->select(
                'ad.id as id_ads',
                'ad.name as name_ads',
                'ct.name as name_category',
                'ad.merchant_id',
                'ad.category_id',
                'ad.category_id',
                'mc.city',
                'mc.province',
                'ad.description',
                'ad.notes',
                'ad.price',
                'ad.picture',
                'ad.count_order',
                'ad.rating',
                'ad.count_view',
                'ad.year',
                'ad.month',
                DB::raw('AVG(ad.rating) as average_rating')
            )
            ->groupBy('ad.year', 'ad.month')
            ->orderBy('ad.month')
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

    public function data_rating_ads_per_periode($month)
    {
        $data = Ads::with('merchant')
            ->where('month', $month)
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
}
