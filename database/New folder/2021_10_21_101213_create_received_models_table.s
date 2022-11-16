<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_receive');
            $table->string('no_invoices');
            $table->integer('id_barang');
            $table->integer('berat');
            $table->integer('id_satuan');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
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
        Schema::dropIfExists('barang_masuk_models');
    }
}
