<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $data_not_active = Merchant::where('is_approve', 'not_approve')->get();
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

    public function data_active_merchant_and_not()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // return response()->json($threeMonthsAgo);
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

    public function data_active_merchant()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Merchant yang aktif dalam 3 bulan terakhir
        $data = Merchant::whereNotNull('last_login')
            ->whereDate('last_login', '>=', $threeMonthsAgo)
            ->get();

        $data_not_active =
            Merchant::whereNotNull('last_login')
            ->whereDate('last_login', '<', $threeMonthsAgo)
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
            $data->id = $data_request['id'];
            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
            $data->save();
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }

        if (!empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'Error',
                'message' => 'Data Not Found'
            ],
        ], 404);
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
            $data->id = $data_request['id'];
            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
            $data->save();
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }

        if (!empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'Error',
                'message' => 'Data Not Found'
            ],
        ], 404);
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
            $data->id = $data_request['id'];
            $data->name = $data_request['name'];
            $data->email = $data_request['email'];
            $data->phone_number = $data_request['telp'];
            $data->address = $data_request['address'];
            $data->city = $data_request['city'];
            $data->province = $data_request['province'];
            $data->id_card_number = $data_request['id_card'];
            $data->npwp = $data_request['npwp'];
            $data->save();
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Error',
                    'message' => 'Internal Server Error'
                ],
                'data' => $error
            ], 500);
        }

        if (!empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully Update data'
                ],
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'Error',
                'message' => 'Data Not Found'
            ],
        ], 404);
    }
}
