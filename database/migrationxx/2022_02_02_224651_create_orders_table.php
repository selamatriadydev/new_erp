<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_invoice');
            $table->string('nama_cust');
            $table->string('jenis_cust');
            $table->integer('cabang_id');
            $table->integer('user_id');
            $table->date('tanggal_kirim');
            $table->date('tanggal_masuk');
            $table->time('jam_kirim');
            $table->string('no_telp');
            $table->string('jenis_order');
            $table->integer('id_kota');
            $table->integer('id_kec');
            $table->integer('id_keluaran');
            $table->string('jalan');
            $table->string('patokan');
            $table->string('bigtotal');
            $table->string('bayar');
            $table->string('sisa');
            $table->string('status');
            $table->string('alasan');
            $table->string('keterangan');
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
        Schema::dropIfExists('orders');
    }
}
