<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeuntunganModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuntungan_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_purchase');
            $table->integer('id_purchase');
            $table->integer('id_bahanbaku');
            $table->integer('harga_pk');
            $table->integer('harga_up');
            $table->integer('quantity');
            $table->integer('sub_totalpk');
            $table->integer('sub_total');
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
        Schema::dropIfExists('keuntungan_models');
    }
}
