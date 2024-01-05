<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_retails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_nota');
            $table->date('tanggal_transaksi');
            $table->string('subtotal_pk');
            $table->string('subtotal_up');
            $table->string('bayar');
            $table->string('kembali');
            $table->integer('cabang_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('transaksi_retails');
    }
}
