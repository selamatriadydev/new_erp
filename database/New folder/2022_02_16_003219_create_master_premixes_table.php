<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPremixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_premixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_barang_model');
            $table->string('code_master');
            $table->string('nama_barang');
            $table->integer('berat');
            $table->integer('id_satuan');
            $table->integer('stok');
            $table->integer('harga_pokok');
            $table->integer('margin');
            $table->integer('harga_jual');
            $table->integer('sub_total_pokok');
            $table->integer('sub_total_jual');
            $table->integer('cabang_id');
            $table->string('nama_gudang');
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
        Schema::dropIfExists('master_premixes');
    }
}
