<?php

namespace App\Http\Controllers\API\Verify;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function index()
    {
        $data = Merchant::all();

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

    public function change_approve(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'data' => 'required|in:approve,not_approve',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Bad Request'
                ],
                'data' => $validator->messages()->all()
            ], 400);
        }

        $data = Merchant::findOrFail($request['id']);
        $data->is_approve = $request['data'];
        $data->save();

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Successfully fetch data'
            ],
            'data' => $data
        ], 200);

        // return response()->json(Merchant::findOrFail($request['id']));
        // Merchant
    }
}
