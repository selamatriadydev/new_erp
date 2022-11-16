<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiutangCabangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutang_cabang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_peminjaman');
            $table->integer('id_peminjaman');
            $table->integer('id_barang');
            $table->integer('harga_pk');
            $table->integer('harga_up');
            $table->integer('quantity');
            $table->integer('sub_totalpk');
            $table->integer('sub_total');
            $table->integer('id_cabang');
            $table->integer('id_peminjam');
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
        Schema::dropIfExists('piutang_cabang_models');
    }
}
