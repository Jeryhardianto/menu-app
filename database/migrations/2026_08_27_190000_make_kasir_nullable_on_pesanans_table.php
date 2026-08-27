<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * kasir baru terisi saat pesanan diambil kasir (Order@updatestatus), dan
     * Order@index memang mencari baris dengan kasir NULL. Migrasi yang menambah
     * kolom ini lupa menandainya nullable, jadi setiap checkout pelanggan gagal
     * dengan "Field 'kasir' doesn't have a default value".
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE pesanans MODIFY kasir BIGINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE pesanans MODIFY kasir BIGINT UNSIGNED NOT NULL');
        }
    }
};
