<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->foreignId('id_user')->constrained('users');
            $table->string('no_transaksi');
            $table->integer('nomor_meja');
            $table->date('tanggal');
            $table->time('waktu');
            $table->unsignedInteger('id_status');
            $table->foreign('id_status')->references('id')->on('status');
            $table->integer('total');
            $table->string('bukti_bayar', 255)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}