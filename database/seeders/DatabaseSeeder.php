<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      
        $this->call([
            UsersTableSeeder::class,
            PermissionTableSeeder::class,
            KategoriTableSeeder::class,
            SubkategoriTableSeeder::class,
            MenusTableSeeder::class,
            StatusTableSeeder::class,
        ]);
    }
}
