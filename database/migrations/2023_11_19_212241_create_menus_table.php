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
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_subkategori');
            $table->string('nama_menu', 255)->nullable();
            $table->integer('harga')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_subkategori')->references('id')->on('subkategori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
