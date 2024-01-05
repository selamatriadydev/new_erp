<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeuntunganGudCabModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuntungan_gud_cab_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_purchase');
            $table->integer('id_purchase');
            $table->integer('id_bahanbaku');
            $table->integer('harga_pk');
            $table->integer('harga_up');
            $table->integer('quantity');
            $table->integer('subtotalpk');
            $table->integer('subtotalup');
            $table->integer('cabang_id');
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
        Schema::dropIfExists('keuntungan_gud_cab_models');
    }
}
