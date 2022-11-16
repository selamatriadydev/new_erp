<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_inv');
            $table->integer('cabang_id');
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->date('tgl_kirim');
            $table->time('jam_kirim');
            $table->text('alamat');
            $table->date('tgl_order');
            $table->integer('big_total');
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
        Schema::dropIfExists('order');
    }
}
