<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Konstruksi',
            ],
            [
                'name' => 'Elektronik Rumah Tangga',
            ],
            [
                'name' => 'Elektronik & Gadget'
            ],
            [
                'name' => 'Jasa Kebersihan'
            ],
            [
                'name' => 'Fotografi & Videografi'
            ],
            [
                'name' => 'Event Organizer'
            ],
            [
                'name' => 'Makanan'
            ],
            [
                'name' => 'Biro Jasa'
            ],
            [
                'name' => 'Creative & Pemrograman'
            ],
            [
                'name' => 'Kendaraan'
            ],
            [
                'name' => 'Kursus'
            ],
            [
                'name' => 'Tour & Travel'
            ],
            [
                'name' => 'Kecantikan'
            ],
            [
                'name' => 'Olahraga & Kesehatan'
            ],
            [
                'name' => 'Pindahan Rumah & Kantor'
            ],
        ]);
    }
}
