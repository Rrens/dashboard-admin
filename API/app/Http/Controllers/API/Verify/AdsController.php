<?php

namespace App\Http\Controllers\API\Verify;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function index()
    {
        $data = Ads::with('sub_category.sub_category_and_categories')->where('is_approve', null)->get();
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

        $data = Ads::findOrFail($request['id']);
        $data->is_approve = $request['data'];
        $data->save();

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Successfully fetch data'
            ],
            'data' => $data
        ], 200);
    }
}
