<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_invoice');
            $table->integer('cabang_id');
            $table->integer('user_id');
            $table->integer('id_paket');
            $table->string('hpp');
            $table->string('harga');
            $table->string('qty');
            $table->string('disc');
            $table->string('cutsale');
            $table->string('subhpp');
            $table->string('subtotal');
            $table->date('tanggal_kirim');
            $table->time('jam_kirim');
            $table->string('status');
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
        Schema::dropIfExists('detail_orders');
    }
}
