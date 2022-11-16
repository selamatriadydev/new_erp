<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaranGudangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_gudang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_pengeluaran');
            $table->integer('id_guna');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->integer('nominal');
            $table->integer('total_price');
            $table->integer('total');
            $table->integer('id_user');
            $table->integer('cabang_id');
            $table->string('ha_akses');
            $table->date('tanggal_pengeluaran');
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
        Schema::dropIfExists('pengeluaran_gudang_models');
    }
}
