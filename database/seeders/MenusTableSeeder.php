<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id_subkategori' => 1,
                'nama_menu' => 'Menu 1',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 1',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 2,
                'nama_menu' => 'Menu 2',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 2',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 3,
                'nama_menu' => 'Menu 3',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 3',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 4,
                'nama_menu' => 'Menu 4',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 4',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 5,
                'nama_menu' => 'Menu 5',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 5',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 6,
                'nama_menu' => 'Menu 6',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 6',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 7,
                'nama_menu' => 'Menu 7',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 7',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_subkategori' => 8,
                'nama_menu' => 'Menu 8',
                'harga' => 15000,
                'deskripsi' => 'Description for Menu 8',
                'gambar' => 'menu/default.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
