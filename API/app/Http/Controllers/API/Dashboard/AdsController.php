<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function data_verify_ads_and_not()
    {
        $data = Ads::select(DB::raw('
                (SUM(CASE WHEN is_approve = "approve" THEN 1 ELSE 0 END) / COUNT(*)) * 100 as approve,
                (SUM(CASE WHEN is_approve = "not_approve" THEN 1 ELSE 0 END) / COUNT(*)) * 100 as not_approve
            '))
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
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
        $data = Ads::with('merchant')
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('is_approve', 'approve')
            ->get();
        $data_not_active = Ads::with('merchant')
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })->where('is_approve', 'not_approve')
            ->get();
        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
                'data_not_active' => $data_not_active
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
            ->whereNull('mc.deleted_at')
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
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
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
            ->whereNull('mc.deleted_at')
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
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
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

    public function ads_detail($id)
    {
        $data = Ads::findOrFail($id);

        if (!empty($data)) {
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

    public function update_verify(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'id_merchant' => $request[0]['id_merchant'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_category' => $request[0]['id_category'],
            'description' => $request[0]['description'],
            'notes' => $request[0]['notes'],
            'price' => $request[0]['price'],
            'count_order' => $request[0]['count_order'],
            'rating' => $request[0]['rating'],
            'count_view' => $request[0]['count_view'],
        ];

        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'id' => 'required',
            'id_merchant' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'notes' => 'required',
            'price' => 'required',
            'count_order' => 'required',
            'rating' => 'required',
            'count_view' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Bad Request'
                ],
            ], 400);
        }

        try {
            $data = Ads::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            $data->name = $data_request['name'];
            $data->merchant_id = $data_request['id_merchant'];
            $data->category_id = $data_request['id_category'];
            $data->description = $data_request['description'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->notes = $data_request['notes'];
            $data->price = $data_request['price'];
            $data->count_order = $data_request['count_order'];
            $data->rating = $data_request['rating'];
            $data->count_view = $data_request['count_view'];
            $data->save();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }
    }

    public function update_ads_favorite(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'id_merchant' => $request[0]['id_merchant'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_category' => $request[0]['id_category'],
            'description' => $request[0]['description'],
            'notes' => $request[0]['notes'],
            'price' => $request[0]['price'],
            'count_order' => $request[0]['count_order'],
            'rating' => $request[0]['rating'],
            'count_view' => $request[0]['count_view'],
        ];

        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'id' => 'required',
            'id_merchant' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'notes' => 'required',
            'price' => 'required',
            'count_order' => 'required',
            'rating' => 'required',
            'count_view' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Bad Request'
                ],
            ], 400);
        }

        try {
            $data = Ads::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            $data->name = $data_request['name'];
            $data->merchant_id = $data_request['id_merchant'];
            $data->category_id = $data_request['id_category'];
            $data->description = $data_request['description'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->notes = $data_request['notes'];
            $data->price = $data_request['price'];
            $data->count_order = $data_request['count_order'];
            $data->rating = $data_request['rating'];
            $data->count_view = $data_request['count_view'];
            $data->save();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }
    }

    public function update_count_rating(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'id_merchant' => $request[0]['id_merchant'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_category' => $request[0]['id_category'],
            'description' => $request[0]['description'],
            'notes' => $request[0]['notes'],
            'price' => $request[0]['price'],
            'count_order' => $request[0]['count_order'],
            'rating' => $request[0]['rating'],
            'count_view' => $request[0]['count_view'],
        ];

        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'id' => 'required',
            'id_merchant' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'notes' => 'required',
            'price' => 'required',
            'count_order' => 'required',
            'rating' => 'required',
            'count_view' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Bad Request'
                ],
            ], 400);
        }

        try {
            $data = Ads::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            $data->name = $data_request['name'];
            $data->merchant_id = $data_request['id_merchant'];
            $data->category_id = $data_request['id_category'];
            $data->description = $data_request['description'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->notes = $data_request['notes'];
            $data->price = $data_request['price'];
            $data->count_order = $data_request['count_order'];
            $data->rating = $data_request['rating'];
            $data->count_view = $data_request['count_view'];
            $data->save();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }
    }
}
