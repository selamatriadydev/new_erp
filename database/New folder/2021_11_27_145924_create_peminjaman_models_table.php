<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeminjamanModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_peminjaman');
            $table->integer('id_barang');
            $table->integer('berat');
            $table->integer('id_satuan');
            $table->integer('harga_pk');
            $table->integer('harga');
            $table->integer('quantity');
            $table->integer('sub_total');
            $table->string('status');
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
        Schema::dropIfExists('peminjaman_models');
    }
}
