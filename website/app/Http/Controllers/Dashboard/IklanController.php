<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class IklanController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        $_URL_VERIFY_AND_NOT = env('API_URL') . 'dashboard/iklan/verify';
        $data_api_verify_and_not = collect(Http::get($_URL_VERIFY_AND_NOT)->json());
        if (!empty($data_api_verify_and_not['data'][0])) {
            $data_verify_and_not = $data_api_verify_and_not['data'];
        } else {
            $data_verify_and_not = null;
        }

        $_URL_VERIFY_FAVORITE_PER_CATEGORIES = env('API_URL') . 'dashboard/iklan/average-favorite-ads';
        $data_api_favorite_per_categories = collect(Http::get($_URL_VERIFY_FAVORITE_PER_CATEGORIES)->json());
        if (!empty($data_api_favorite_per_categories['data'][0])) {
            $data_favorite_per_categories = $data_api_favorite_per_categories['data'];
            // dd($data_name_categories);
            $array_name_categories = [];
            foreach ($data_favorite_per_categories as $value) {
                $array_name_categories[] = '"' . (string) $value['name_category'] . '"';
            }
            $name_categories = '[' . implode(', ', $array_name_categories) . ']';

            // RATING
            $array_rating_categories = [];
            foreach ($data_favorite_per_categories as $value) {
                $array_rating_categories[] = (float) $value['rating'];
            }
            $rating_categories = implode(', ', $array_rating_categories);

            // ID_CATEGORY
            $array_id = [];
            foreach ($data_favorite_per_categories as $value) {
                $array_id[] = (float) $value['category_id'];
            }
            $id = implode(', ', $array_id);
            // dd($id);
        } else {
            $data_favorite_per_categories = null;
        }

        $_URL_VERIFY_FAVORITE_PER_PERIODE = env('API_URL') . 'dashboard/iklan/rating-ads-periode';
        $data_api_favorite_per_periode = collect(Http::get($_URL_VERIFY_FAVORITE_PER_PERIODE)->json());
        if (!empty($data_api_favorite_per_periode['data'][0])) {
            $data_favorite_per_periode = $data_api_favorite_per_periode['data'];

            // MONTH
            $array_month = [];
            foreach ($data_favorite_per_periode as $value) {
                $array_month[] = (int) $value['month'];
            }
            $rating_month = implode(', ', $array_month);

            // RATING
            $array_rating_periode = [];
            foreach ($data_favorite_per_periode as $value) {
                // dd($data_favorite_per_periode);
                $array_rating_periode[] = (float) $value['rating'];
            }
            $rating_periode = implode(', ', $array_rating_periode);
        } else {
            $data_favorite_per_periode = null;
        }

        // dd($rating_periode);
        return view('admin.page.dashboard.iklan', compact(
            'active',
            'data_verify_and_not',
            'data_favorite_per_categories',
            'name_categories',
            'rating_categories',
            'id',
            'data_favorite_per_periode',
            'rating_month',
            'rating_periode',
            'data_favorite_per_periode',
        ));
    }

    public function updateVerifyOrNot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit_verify_detail' => 'required|string',
            'id_edit_verify_detail' => 'required',
            'id_merchant_edit_verify_detail' => 'required',
            'city_edit_verify_detail' => 'required|string',
            'province_edit_verify_detail' => 'required|string',
            'id_category_edit_verify_detail' => 'required',
            'description_edit_verify_detail' => 'required',
            'notes_edit_verify_detail' => 'required',
            'price_edit_verify_detail' => 'required',
            'count_order_edit_verify_detail' => 'required',
            'rating_edit_verify_detail' => 'required',
            'count_view_edit_verify_detail' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_verify_detail,
            'id' => $request->id_edit_verify_detail,
            'id_merchant' => $request->id_merchant_edit_verify_detail,
            'city' => $request->city_edit_verify_detail,
            'province' => $request->province_edit_verify_detail,
            'id_category' => $request->id_category_edit_verify_detail,
            'description' => $request->description_edit_verify_detail,
            'notes' => $request->notes_edit_verify_detail,
            'price' => $request->price_edit_verify_detail,
            'count_order' => $request->count_order_edit_verify_detail,
            'rating' => $request->rating_edit_verify_detail,
            'count_view' => $request->count_view_edit_verify_detail,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/update-verify';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function updateAdsFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit_verify_detail' => 'required|string',
            'id_edit_verify_detail' => 'required',
            'id_merchant_edit_verify_detail' => 'required',
            'city_edit_verify_detail' => 'required|string',
            'province_edit_verify_detail' => 'required|string',
            'id_category_edit_verify_detail' => 'required',
            'description_edit_verify_detail' => 'required',
            'notes_edit_verify_detail' => 'required',
            'price_edit_verify_detail' => 'required',
            'count_order_edit_verify_detail' => 'required',
            'rating_edit_verify_detail' => 'required',
            'count_view_edit_verify_detail' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_verify_detail,
            'id' => $request->id_edit_verify_detail,
            'id_merchant' => $request->id_merchant_edit_verify_detail,
            'city' => $request->city_edit_verify_detail,
            'province' => $request->province_edit_verify_detail,
            'id_category' => $request->id_category_edit_verify_detail,
            'description' => $request->description_edit_verify_detail,
            'notes' => $request->notes_edit_verify_detail,
            'price' => $request->price_edit_verify_detail,
            'count_order' => $request->count_order_edit_verify_detail,
            'rating' => $request->rating_edit_verify_detail,
            'count_view' => $request->count_view_edit_verify_detail,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/update-ads-favorite';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function updateCountRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_edit_verify_detail' => 'required|string',
            'id_edit_verify_detail' => 'required',
            'id_merchant_edit_verify_detail' => 'required',
            'city_edit_verify_detail' => 'required|string',
            'province_edit_verify_detail' => 'required|string',
            'id_category_edit_verify_detail' => 'required',
            'description_edit_verify_detail' => 'required',
            'notes_edit_verify_detail' => 'required',
            'price_edit_verify_detail' => 'required',
            'count_order_edit_verify_detail' => 'required',
            'rating_edit_verify_detail' => 'required',
            'count_view_edit_verify_detail' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'name' => $request->name_edit_verify_detail,
            'id' => $request->id_edit_verify_detail,
            'id_merchant' => $request->id_merchant_edit_verify_detail,
            'city' => $request->city_edit_verify_detail,
            'province' => $request->province_edit_verify_detail,
            'id_category' => $request->id_category_edit_verify_detail,
            'description' => $request->description_edit_verify_detail,
            'notes' => $request->notes_edit_verify_detail,
            'price' => $request->price_edit_verify_detail,
            'count_order' => $request->count_order_edit_verify_detail,
            'rating' => $request->rating_edit_verify_detail,
            'count_view' => $request->count_view_edit_verify_detail,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/update-count-rating';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function deleteCountRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/destroy-count-rating';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }

    public function deleteFavoriteAds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/destroy-favorite-ads';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }
    public function deleteVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = [
            'id' => $request->id,
        ];

        $_URL = env('API_URL') . 'dashboard/iklan/destroy-verify';

        try {
            $response = Http::post($_URL, [
                $data
            ]);
        } catch (Exception $error) {
            dd($error->getMessage());
        }

        if ($response->status() == 200) {

            $responseData = $response->json();
            Alert::toast($responseData['meta']['message'], 'success');
            return back();
        } else {
            $errorMessage = $response->json();
            Alert::error($errorMessage['meta']['message']);
            return back();
        }
    }
}
