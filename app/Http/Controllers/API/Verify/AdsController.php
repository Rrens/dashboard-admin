<?php

namespace App\Http\Controllers\API\Verify;

use App\Http\Controllers\Controller;
use App\Mail\MessageNotApprove;
use App\Models\Ads;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function index()
    {
        // $data = Ads::with('sub_category.sub_category_and_categories')->where('is_approve', null)->get();
        $data = Ads::where('is_approve', null)->get();
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
            $data_email = Ads::with('merchant')->where('id', $request['id'])->first();
            $request['email'] = $data_email->merchant[0]->email;
            $request['name'] = $data_email->merchant[0]->name;

            Mail::send(new MessageNotApprove($request));
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
