<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_category')->insert([
            [
                'category_id' => 1,
                'name' => 'Arsitek',

            ],
            [
                'category_id' => 1,
                'name' => 'Kontraktor Bangunan',
            ],
            [
                'category_id' => 1,
                'name' => 'Jasa Pertukangan',
            ],
            [
                'category_id' => 1,
                'name' => 'Bengkel Las',
            ],
            [
                'category_id' => 1,
                'name' => 'Interior Designer',
            ],
            [
                'category_id' => 1,
                'name' => 'Instalasi Kanopi',
            ],
            [
                'category_id' => 1,
                'name' => 'Tukang Taman',
            ],
            [
                'category_id' => 1,
                'name' => 'Pagar & Teralis',
            ],
            [
                'category_id' => 1,
                'name' => 'Kolam Renang',
            ],
            [
                'category_id' => 2,
                'name' => 'Pemasangan & Service Ac',
            ],
            [
                'category_id' => 2,
                'name' => 'Service Kompor',
            ],
            [
                'category_id' => 2,
                'name' => 'Kelistrikan',
            ],
            [
                'category_id' => 2,
                'name' => 'Service TV',
            ],
            [
                'category_id' => 2,
                'name' => 'Service Kulkas',
            ],
            [
                'category_id' => 2,
                'name' => 'Service Pemanas Air',
            ],
            [
                'category_id' => 2,
                'name' => 'Service Mesin Cuci',
            ],
            [
                'category_id' => 2,
                'name' => 'Service Pompa Air',
            ],
            [
                'category_id' => 2,
                'name' => 'Duplikat Kunci',
            ],
            [
                'category_id' => 2,
                'name' => 'Alarm & CCTV',
            ],
            [
                'category_id' => 3,
                'name' => 'Service Handphone',
            ],
            [
                'category_id' => 3,
                'name' => 'Service Laptop',
            ],
            [
                'category_id' => 3,
                'name' => 'Service Jam',
            ],
            [
                'category_id' => 4,
                'name' => 'Daily Cleaning',
            ],
            [
                'category_id' => 4,
                'name' => 'Sedot Tungau',
            ],
            [
                'category_id' => 4,
                'name' => 'Cuci Karpet',
            ],
            [
                'category_id' => 5,
                'name' => 'Jasa Fotografi',
            ],
            [
                'category_id' => 5,
                'name' => 'Jasa Videografi',
            ],
            [
                'category_id' => 5,
                'name' => 'Service Kamera',
            ],
            [
                'category_id' => 6,
                'name' => 'Jasa Event Pernikahan',
            ],
            [
                'category_id' => 6,
                'name' => 'Jasa Event Ulang Tahun',
            ],
            [
                'category_id' => 6,
                'name' => 'Event lainnya',
            ],
            [
                'category_id' => 7,
                'name' => 'Catering',
            ],
            [
                'category_id' => 8,
                'name' => 'Design Grafis',
            ],
            [
                'category_id' => 8,
                'name' => 'Percetakan',
            ],
            [
                'category_id' => 8,
                'name' => 'Programmer',
            ],
            [
                'category_id' => 8,
                'name' => 'Video Editor',
            ],
            [
                'category_id' => 9,
                'name' => 'Sewa Motor',
            ],
            [
                'category_id' => 9,
                'name' => 'Sewa Mobil',
            ],
            [
                'category_id' => 9,
                'name' => 'Ban & Oli',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Bahasa Inggris',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Bahasa Jepang',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Bahasa Mandarin',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Pembelajaran',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Kecantikan',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Pemrograman',
            ],
            [
                'category_id' => 10,
                'name' => 'Kursus Lainnya',
            ],
            [
                'category_id' => 11,
                'name' => 'Jasa Tourguide',
            ],
            [
                'category_id' => 11,
                'name' => 'Travel Buddies',
            ],
            [
                'category_id' => 11,
                'name' => 'Eyelash & Brow',
            ],
            [
                'category_id' => 11,
                'name' => 'Waxing',
            ],
            [
                'category_id' => 11,
                'name' => 'Reflexologi',
            ],
            [
                'category_id' => 11,
                'name' => 'Perawatan Rambut',
            ],
            [
                'category_id' => 11,
                'name' => 'Pijat',
            ],
            [
                'category_id' => 11,
                'name' => 'Kuku (nails art)',
            ],
            [
                'category_id' => 12,
                'name' => 'Muay Thai Trainer',
            ],
            [
                'category_id' => 12,
                'name' => 'Yoga Trainer',
            ],
            [
                'category_id' => 12,
                'name' => 'Personal Trainer',
            ],
            [
                'category_id' => 13,
                'name' => 'Sewa Mobil Box/Pickup',
            ],
            [
                'category_id' => 13,
                'name' => 'Jasa Angkut Barang',
            ],
        ]);
    }
}
