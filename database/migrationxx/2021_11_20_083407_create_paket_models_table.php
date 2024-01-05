<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaketModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_paket');
            $table->integer('id_komponen');
            $table->integer('hpp');
            $table->integer('harga_jual');
            $table->string('gambar');
            $table->integer('cabang_id');
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
        Schema::dropIfExists('paket_models');
    }
}
