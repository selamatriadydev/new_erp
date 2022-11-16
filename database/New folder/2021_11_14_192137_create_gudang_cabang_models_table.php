<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGudangCabangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_cabang_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_bahanbaku');
            $table->integer('harga_pk');
            $table->integer('harga_up');
            $table->integer('stok');
            $table->string('sub_totalpk');
            $table->string('sub_total');
            $table->integer('cabang_id');
            $table->string('gudang');
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
        Schema::dropIfExists('gudang_cabang_models');
    }
}
