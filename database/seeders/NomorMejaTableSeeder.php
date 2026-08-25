<?php

namespace Database\Seeders;

use App\Models\NomorMeja;
use Illuminate\Database\Seeder;

class NomorMejaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $nomor) {
            NomorMeja::create([
                'nomormeja' => 'Meja ' . $nomor,
                'is_available' => false,
            ]);
        }
    }
}
