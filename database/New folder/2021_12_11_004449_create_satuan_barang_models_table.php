<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatuanBarangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satuan_barang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nama_barang');
            $table->integer('no');
            $table->integer('value_satuan');
            $table->string('harga_pk');
            $table->string('margin');
            $table->string('harga_up');
            $table->string('stok');
            $table->integer('id_satuan');
            $table->string('hak_akses');
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
        Schema::dropIfExists('satuan_barang_models');
    }
}
