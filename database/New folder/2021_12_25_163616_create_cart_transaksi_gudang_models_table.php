<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTransaksiGudangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_transaksi_gudang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_invoice');
            $table->integer('user_id');
            $table->integer('id_barang');
            $table->integer('harga_pk');
            $table->integer('harga_up');
            $table->integer('qty');
            $table->integer('discount');
            $table->integer('cut_sale');
            $table->integer('sub_total');
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
        Schema::dropIfExists('cart_transaksi_gudang_models');
    }
}
