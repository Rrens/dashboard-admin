<?php

namespace App\Http\Controllers\API\Verify;

use App\Http\Controllers\Controller;
use App\Mail\MessageNotApprove;
use App\Models\Merchant;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function index()
    {
        $data = Merchant::where('is_approve', null)->get();
        $data_category = SubCategory::all();

        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
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

    // public function detail(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'meta' => [
    //                 'status' => 'Failed',
    //                 'message' => 'Bad Request'
    //             ],
    //             'data' => $validator->messages()->all()
    //         ], 400);
    //     }

    //     $data = Merchant::findOrFail($request['id']);
    //     if (!empty($data)) {
    //         return response()->json([
    //             'meta' => [
    //                 'status' => 'success',
    //                 'message' => 'Successfully fetch data'
    //             ],
    //             'data' => $data
    //         ], 200);
    //     }

    //     return response()->json([
    //         'meta' => [
    //             'status' => 'Failed',
    //             'message' => 'Data Not Found'
    //         ],
    //     ], 404);
    // }

    public function change_approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|in:approve,not_approve',
            'id' => 'required',
            'message' => 'nullable',
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

        if ($request['data'] == 'not_approve') {
            $date = Carbon::now();
            $formattedDate = $date->formatLocalized('%A, %d %B %Y');
            $request["date"] = $formattedDate;

            // $data = User::where('email', $request->email)->first();
            $data_email = Merchant::findOrFail($request['id']);
            $request['email'] = $data_email->email;
            $request['name'] = $data_email->name;

            Mail::send(new MessageNotApprove($request));
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
    }
}
