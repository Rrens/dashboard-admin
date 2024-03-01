<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Categories;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function data_verify_ads_and_not()
    {
        $approve = Ads::where('deleted_at', null)
            ->where('is_approve', 'approve')->count();
        $not_approve =
            Ads::where('deleted_at', null)
            ->where('is_approve', 'not_approve')->count();
        $count_approve_add_not_approve = $approve + $not_approve;

        $data = Ads::select(DB::raw('
                (SUM(CASE WHEN is_approve = "approve" THEN 1 ELSE 0 END) / ' . $count_approve_add_not_approve . ') * 100 as approve,
                (SUM(CASE WHEN is_approve = "not_approve" THEN 1 ELSE 0 END) / ' . $count_approve_add_not_approve . ') * 100 as not_approve
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

    public function data_verify_ads($status, $month, $year)
    {
        // $data = Ads::with('merchant')
        //     ->whereHas('merchant', function ($query) {
        //         $query->whereNull('deleted_at');
        //     })
        //     ->where('is_approve', 'approve')
        //     ->get();
        // dd($status);
        $data = Ads::with('merchant')
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('is_approve', $status)
            ->where('month', $month)
            ->where('year', $year)
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
                'ad.month',
                DB::raw('AVG(ad.rating) as average_rating'),
                DB::raw('(SUM(ad.rating) / (COUNT(ad.rating) * 5)) * 100 as rating_percentage')
            )
            ->whereNull('mc.deleted_at')
            ->groupBy('ad.category_id')
            ->orderBy('month', 'asc')
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

    public function data_favorite_ads_per_categories($status, $month, $year)
    {
        $averageRating = Ads::average('rating');
        // dd($status);

        $data = Ads::with('merchant')
            // ->whereHas('merchant', function ($query) {
            //     $query->whereNull('deleted_at');
            // })
            // ->having(DB::raw('COUNT(rating)'), '>', $averageRating)
            // ->groupBy('month')
            ->where('rating', '>', $averageRating)
            ->where('category_id', $status)
            ->where('month', $month)
            ->where('year', $year)
            ->whereNull('deleted_at')
            ->orderBy('count_order', 'desc')
            ->get();
        // return response()->json($data);

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
            ->join('transaction as t', 't.ads_id', 'ad.id')
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

    public function data_rating_ads_per_periode($month, $category)
    {
        // $data = Ads::with('merchant')
        //     ->whereHas('categories', function ($query) use ($category) {
        //         $query->where('name', $category);
        //     })
        //     ->whereHas('merchant', function ($query) {
        //         $query->whereNull('deleted_at');
        //     })
        //     ->get();
        $averageRating = Ads::average('rating');

        // $data = DB::table('transaction as t')
        //     ->select(
        //         't.id as id',
        //         'm.id as merchant_id',
        //         'ad.id as ads_id',
        //         't.total_transaction as total_transaction',
        //         't.month as month',
        //         'ad.category_id',
        //         'ad.rating'
        //     )
        //     ->join('ads as ad', 'ad.id', '=', 't.ads_id')
        //     ->join('merchants as m', 'm.id', '=', 't.merchant_id')
        //     ->join('categories as c', 'ad.category_id', '=', 'c.id')
        //     ->where('c.name', $category)
        //     ->where('t.month', $month)
        //     ->where('ad.rating', '>', $averageRating)
        //     ->whereNull('m.deleted_at')
        //     ->whereNull('ad.deleted_at')
        //     ->whereNull('c.deleted_at')
        //     ->whereNull('t.deleted_at')
        //     ->orderBy('c.name', 'asc')
        //     // ->groupBy('t.merchant_id')
        //     ->get();

        $data = DB::table('ads as ad')
            ->select(
                't.id as id',
                'ad.merchant_id as merchant_id',
                'ad.category_id as category_id',
                'ad.id as ads_id',
                't.total_transaction as total_transaction',
                'ad.month as month'
            )
            ->join('transaction as t', 't.ads_id', 'ad.id')
            ->join('categories as c', 'ad.category_id', '=', 'c.id')
            ->where('ad.rating', '>', $averageRating)
            ->whereNull('ad.deleted_at')
            ->where('ad.month', $month)
            ->where("c.name", $category)
            ->orderBy('t.total_transaction', 'desc')
            ->groupBy('t.id')
            ->get();
        // return response()->json($averageRating);

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

    public function destroy_favorite_ads(Request $request)
    {
        $data_request = [
            'id' => $request[0]['id'],
        ];

        $validator = Validator::make($data_request, [
            'id' => 'required',
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

            $data->delete();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Delete data'
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

    public function destroy_count_rating(Request $request)
    {
        $data_request = [
            'id' => $request[0]['id'],
        ];

        $validator = Validator::make($data_request, [
            'id' => 'required',
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

            $data->delete();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Delete data'
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

    public function destroy_verify(Request $request)
    {
        $data_request = [
            'id' => $request[0]['id'],
        ];

        $validator = Validator::make($data_request, [
            'id' => 'required',
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

            $data->delete();

            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Delete data'
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

    public function update(Request $request)
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
