<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Models\User::factory()->create([
            
            'nama' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'alamat' => '123 Main Street',
            'telepon' => '1234567890',
            'role' => 'Owner'
        ]);

        \App\Models\User::factory()->create([
            
            'nama' => 'Kasir',
            'email' => 'kasir@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
             'alamat' => '123 Main Street',
            'telepon' => '1234567890',
            'role' => 'Kasir'
        ]);

        \App\Models\User::factory()->create([
            
            'nama' => 'Kitchen',
            'email' => 'kitchen@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'alamat' => '123 Main Street',
            'telepon' => '1234567890',
            'role' => 'Kitchen'
        ]);

        \App\Models\User::factory()->create([
            
            'nama' => 'Pelanggan 1',
            'email' => 'pelanggan1@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'alamat' => '123 Main Street',
            'telepon' => '1234567890',
            'role' => 'Pelanggan'
        ]);

        
    }
}
