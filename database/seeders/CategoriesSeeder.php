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
                'name' => 'Elektronik dan Gadget'
            ],
            [
                'name' => 'Jasa Kebersihan'
            ],
            [
                'name' => 'Fotografi dan Videografi'
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
                'name' => 'Creative dan Pemrograman'
            ],
            [
                'name' => 'Kendaraan'
            ],
            [
                'name' => 'Kursus'
            ],
            [
                'name' => 'Tour dan Travel'
            ],
            [
                'name' => 'Kecantikan'
            ],
            [
                'name' => 'Olahraga dan Kesehatan'
            ],
            [
                'name' => 'Pindahan Rumah dan Kantor'
            ],
        ]);
    }
}
