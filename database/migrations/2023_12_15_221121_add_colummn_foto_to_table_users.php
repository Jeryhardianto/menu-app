<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
             // default value
            $table->string('foto')->default('users/default.jpg')->after('role');
            $table->string('alamat')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->rememberToken()->after('password')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn('foto');
        });
    }
};
