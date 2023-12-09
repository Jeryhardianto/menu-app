<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubkategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subkategori')->insert([
            [
                'id_kategori' => 2,
                'subketagori' => 'Best Seller Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 1,
                'subketagori' => 'Nasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 1,
                'subketagori' => 'Indomie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 1,
                'subketagori' => 'Cemilan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
            [
                'id_kategori' => 2,
                'subketagori' => 'Non Kopi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2,
                'subketagori' => 'Kopi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2,
                'subketagori' => 'Tea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2,
                'subketagori' => 'Kemasan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
 
        ]);
    }
}
