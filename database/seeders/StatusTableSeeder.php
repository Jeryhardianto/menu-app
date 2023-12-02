<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            [
               
                'status' => 'PENDING',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               
                'status' => 'IN PROGRESS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               
                'status' => 'REJECT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               
                'status' => 'CANCEL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
              
                'status' => 'DEVLIVERED',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
              
                'status' => 'COMPLETED',
                'created_at' => now(),
                'updated_at' => now(),
            ]
 
        ]);
    }
}
