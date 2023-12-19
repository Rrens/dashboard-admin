<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function data_verify_merchant_and_not()
    {
        $approve = Merchant::where('deleted_at', null)
            ->where('is_approve', 'approve')->count();
        $not_approve =
            Merchant::where('deleted_at', null)
            ->where('is_approve', 'not_approve')->count();
        $count_approve_add_not_approve = $approve + $not_approve;
        $data = Merchant::select(DB::raw('
        (SUM(CASE WHEN is_approve = "approve" THEN 1 ELSE 0 END) / ' . $count_approve_add_not_approve . ') * 100 as approve,
        (SUM(CASE WHEN is_approve = "not_approve" THEN 1 ELSE 0 END) / ' . $count_approve_add_not_approve . ') * 100 as not_approve,
        SUM(CASE WHEN is_approve IS NULL THEN 1 ELSE 0 END) as null_count, COUNT(*) * 100 as total_count
        '))
            ->where('deleted_at', null)
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

    public function data_verify_merchant($status, $month, $year)
    {
        if ($status == 'verify') {
            $data = Merchant::where('is_approve', 'approve')
                ->where('deleted_at', null)
                ->where('month', $month)
                ->where('year', $year)
                ->get();
        } else {
            $data = Merchant::where('is_approve', 'not_approve')
                ->where('deleted_at', null)
                ->where('month', $month)
                ->where('year', $year)
                ->get();
        }
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

    public function data_active_merchant_and_not()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // return response()->json($threeMonthsAgo);
        $approve = Merchant::where('deleted_at', null)
            ->where('is_approve', 'approve')->count();
        $not_approve =
            Merchant::where('deleted_at', null)
            ->where('is_approve', 'not_approve')->count();
        $count_approve_add_not_approve = $approve + $not_approve;
        $data = Merchant::selectRaw('
            (SUM(CASE WHEN last_login >= ? THEN 1 ELSE 0 END) / COUNT(*)) * 100 as active,
            (SUM(CASE WHEN last_login < ? THEN 1 ELSE 0 END) / COUNT(*)) * 100 as not_active,
            SUM(CASE WHEN last_login IS NULL THEN 1 ELSE 0 END) as null_count, COUNT(*) * 100 as total_count
        ', [$threeMonthsAgo, $threeMonthsAgo])
            ->where('deleted_at', null)
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

    public function data_active_merchant($status, $month, $year)
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Merchant yang aktif dalam 3 bulan terakhir
        if ($status == 'aktif') {

            $data = Merchant::whereNotNull('last_login')
                ->whereDate('last_login', '>=', $threeMonthsAgo)
                ->where('deleted_at', null)
                ->where('month', $month)
                ->where('year', $year)
                ->get();
        } else {
            $data =
                Merchant::whereNotNull('last_login')
                ->whereDate('last_login', '<', $threeMonthsAgo)
                ->where('deleted_at', null)
                ->where('month', $month)
                ->where('year', $year)
                ->get();
        }

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

    public function data_dashboard_merchant_category($month, $category)
    {
        $data = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->join('categories as c', 'c.id', '=', 'm.category_id')
            ->join('sub_category as sc', 'c.id', '=', 'sc.category_id')
            // ->select(
            //     DB::raw('transaction.year'),
            //     DB::raw('transaction.month'),
            //     DB::raw('COUNT(c.name) as data'),
            //     DB::raw('m.id')
            // )
            ->where(function ($query) use ($month) {
                $query->where('transaction.month', $month);
            })
            ->where('transaction.month', $month)
            // ->groupBy('c.id')
            // ->orderBy('c.id', 'asc')
            ->where('sc.name', $category)
            ->where('m.deleted_at', null)
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

    public function avgTransactionMerchantPerPeriod()
    {

        $month = Transaction::groupBy('month')
            ->orderBy('month', 'asc')
            ->with('merchant')
            ->whereHas('merchant', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->pluck('month');

        $data = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->select(
                DB::raw('transaction.year'),
                DB::raw('transaction.month'),
                DB::raw('SUM(transaction.total_transaction) as total_transaction'),
                DB::raw('m.id')
            )
            ->groupBy('year', 'month')
            ->orderBy('month', 'asc')
            ->where('m.deleted_at', null)
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
            ->with('merchant')
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

    public function merchant_detail($id)
    {
        $data = Merchant::findOrFail($id);

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
            'email' => $request[0]['email'],
            'telp' => $request[0]['telp'],
            'address' => $request[0]['address'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_card' => $request[0]['id_card'],
            'npwp' => $request[0]['npwp'],
            'last_login' => $request[0]['last_login'],
            'image' => $request[0]['image'],
        ];



        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'id' => 'required',
            'email' => 'required|email',
            'telp' => 'required|numeric',
            'address' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'id_card' => 'required|numeric',
            'npwp' => 'required',
            'last_login' => 'required',
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
            $data = Merchant::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = bin2hex(time() . '-merchant-' . $request->name) . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/uploads/merchant/', $image, $image_name);
                $data->profile_picture = $image_name;
            }

            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
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

    public function update_average(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'email' => $request[0]['email'],
            'telp' => $request[0]['telp'],
            'address' => $request[0]['address'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_card' => $request[0]['id_card'],
            'npwp' => $request[0]['npwp'],
            'last_login' => $request[0]['last_login'],
        ];

        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'id' => 'required',
            'image' => 'image|mimes:png,jpg,jpg|max:2048',
            'email' => 'required|email',
            'telp' => 'required|numeric',
            'address' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'id_card' => 'required|numeric',
            'npwp' => 'required',
            'last_login' => 'required',
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
            $data = Merchant::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
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

    public function update_active_or_not(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'email' => $request[0]['email'],
            'telp' => $request[0]['telp'],
            'address' => $request[0]['address'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_card' => $request[0]['id_card'],
            'npwp' => $request[0]['npwp'],
            'last_login' => $request[0]['last_login'],
        ];

        $validator = Validator::make($data_request, [
            'name' => 'required|string',
            'image' => 'image|mimes:png,jpg,jpg|max:2048',
            'id' => 'required',
            'email' => 'required|email',
            'telp' => 'required|numeric',
            'address' => 'required',
            'city' => 'required|string',
            'province' => 'required|string',
            'id_card' => 'required|numeric',
            'npwp' => 'required',
            'last_login' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Bad Request'
                ],
                'data' => $validator->messages()->all()
            ], 400);
        }

        try {
            $data = Merchant::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ]
                ], 404);
            }

            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
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

    public function destroy_active(Request $request)
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
            $data = Merchant::findOrFail($data_request['id']);

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

    public function destroy_average(Request $request)
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
            $data = Merchant::findOrFail($data_request['id']);

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
            $data = Merchant::findOrFail($data_request['id']);

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

    // public function test($id)
    // {
    //     $data = Merchant::findOrFail($id);
    //     $data->delete();
    //     return response()->json([
    //         'meta' => [
    //             'status' => 'success',
    //             'message' => 'Successfully Delete data'
    //         ], 'data' => $data
    //     ], 200);
    // }

    public function verifyDetailPerMonth($status)
    {
        $month = Merchant::groupBy('month')
            ->orderBy('month', 'asc')
            ->whereNull('deleted_at')
            ->pluck('month');

        if ($status == 'verify') {
            $status = 'approve';
        }

        if ($status == 'not-verify') {
            $status = 'not_approve';
        }

        $data = DB::table('merchants')
            ->select(
                'year',
                'month',
                DB::raw('SUM(CASE WHEN is_approve = "' . $status . '" THEN 1 ELSE 0 END) as data')
            )
            ->groupBy('month')
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
        $month = Merchant::groupBy('month')
            ->orderBy('month', 'asc')
            ->whereNull('deleted_at')
            ->pluck('month');

        $data = null;
        $threeMonthsAgo = Carbon::now()->subMonths(3);
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
                ->whereNull('deleted_at')
                ->where('year', 2023)
                ->get();
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
                ->whereNull('deleted_at')
                ->where('year', 2023)
                ->get();
        }

        // dd($data);


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

    public function avgTransactionMerchantPerMonth($month)
    {
        $month = Merchant::groupBy('month')
            ->orderBy('month', 'asc')
            ->whereNull('deleted_at')
            ->pluck('month');

        $data = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->select(
                DB::raw('transaction.year'),
                DB::raw('transaction.month'),
                DB::raw('SUM(transaction.total_transaction) as total_transaction'),
                DB::raw('m.id')
            )
            ->groupBy('year', 'month')
            ->orderBy('month', 'asc')
            ->where('m.deleted_at', null)
            ->get();
    }

    public function average_transaction_merchant_per_month($status)
    {
        // $month = Transaction::groupBy('month')
        //     ->orderBy('month', 'asc')
        //     ->with('merchant')
        //     ->whereHas('merchant', function ($query) {
        //         $query->whereNull('deleted_at');
        //     })
        //     ->pluck('month');
        $month = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->join('sub_category as sc', 'm.category_id', '=', 'sc.category_id')
            ->select('sc.name')
            ->groupBy('sc.category_id')
            ->orderBy('sc.category_id', 'asc')
            ->where('m.deleted_at', null)
            ->where(function ($query) use ($status) {
                $query->where('transaction.month', $status);
            })
            ->get();
        // return response()->json($month);
        $data = Transaction::join('merchants as m', 'transaction.merchant_id', '=', 'm.id')
            ->join('categories as c', 'c.id', '=', 'm.category_id')
            ->join('sub_category as sc', 'c.id', '=', 'sc.category_id')
            ->select(
                DB::raw('transaction.year'),
                DB::raw('transaction.month'),
                DB::raw('COUNT(c.name) as data'),
                DB::raw('m.id')
            )
            ->where(function ($query) use ($status) {
                $query->where('transaction.month', $status);
            })
            ->groupBy('c.id')
            ->orderBy('c.id', 'asc')
            ->where('m.deleted_at', null)
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

    public function update(Request $request)
    {
        $data_request = [
            'name' => $request[0]['name'],
            'id' => $request[0]['id'],
            'email' => $request[0]['email'],
            'telp' => $request[0]['telp'],
            'address' => $request[0]['address'],
            'city' => $request[0]['city'],
            'province' => $request[0]['province'],
            'id_card' => $request[0]['id_card'],
            'npwp' => $request[0]['npwp'],
            'last_login' => $request[0]['last_login'],
        ];

        $validator = Validator::make($data_request, [
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
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Bad Request'
                ],
            ], 400);
        }

        try {
            $data = Merchant::findOrFail($data_request['id']);

            if (empty($data)) {

                return response()->json([
                    'meta' => [
                        'status' => 'Error',
                        'message' => 'Data Not Found'
                    ],
                ], 404);
            }

            $data_request = [
                'name' => $request[0]['name'],
                'id' => $request[0]['id'],
                'email' => $request[0]['email'],
                'telp' => $request[0]['telp'],
                'address' => $request[0]['address'],
                'city' => $request[0]['city'],
                'province' => $request[0]['province'],
                'id_card' => $request[0]['id_card'],
                'npwp' => $request[0]['npwp'],
                'last_login' => $request[0]['last_login'],
            ];

            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
            $data->last_login = $data_request['last_login'];
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
