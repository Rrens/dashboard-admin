<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ads')->insert([
            [
                'user_id' => 1,
                'description' => 'gatau diisi apa',
                'notes'  => 'ini pokok catatan',
                'price' => 10000,
                'count_order' => 10,
                'rating' => 'gatau',
                'count_view' => 100,
            ],
            [
                'user_id' => 2,
                'description' => 'gatau apa',
                'notes'  => 'ini catatan',
                'price' => 2000,
                'count_order' => 5,
                'rating' => 'gatau',
                'count_view' => 50,
            ]
        ]);
    }
}
