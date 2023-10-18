<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merchants')->insert([
            [
                'user_id' => 1,
                'name' => 'BAKSO MERCON',
                'email'  => 'mercon@gmail.com',
                'phone_number' => '0812773881928',
                'address' => 'jalan raya indah permai no 32',
                'city' => 'surabaya',
                'province' => 'jawa timur',
                'id_card_number' => '9319002992920',
                'npwp' => '02991929993039',
            ],
            [
                'user_id' => 2,
                'name' => 'LIDAH ARWANA',
                'email'  => 'arwana@gmail.com',
                'phone_number' => '081291298392',
                'address' => 'jalan indah gubuk no 32',
                'city' => 'surabaya',
                'province' => 'jawa timur',
                'id_card_number' => '329923929019',
                'npwp' => '0299192999388299',
            ]
        ]);
    }
}
