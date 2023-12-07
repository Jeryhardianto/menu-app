<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('id_pesanan', 40);
            $table->foreign('id_pesanan')->references('id')->on('pesanans');
            $table->unsignedInteger('id_menu');
            $table->foreign('id_menu')->references('id')->on('menus');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('subtotal');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
