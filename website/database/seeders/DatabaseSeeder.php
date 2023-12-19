<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ads;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            CategoriesSeeder::class,
            MerchantSeeder::class,
            AdsSeeder::class,
            SubCategorySeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
