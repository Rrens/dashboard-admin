<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IklantController extends Controller
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
}
