<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGudangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_barang');
            $table->integer('harga_pk');
            $table->integer('margin');
            $table->integer('harga_up');
            $table->integer('stok');
            $table->integer('sub_totalpk');
            $table->integer('sub_total');
            $table->integer('cabang_id');
            $table->integer('berat');
            $table->integer('id_satuan');
            $table->string('gudang');
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
        Schema::dropIfExists('gudang_models');
    }
}
