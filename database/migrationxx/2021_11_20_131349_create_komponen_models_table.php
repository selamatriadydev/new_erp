<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomponenModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_komponen');
            $table->integer('cabang_id');
            $table->integer('id_item');
            $table->integer('hpp');
            $table->integer('total_hpp');
            $table->integer('harga_jual');
            $table->integer('total_harga_jual');
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
        Schema::dropIfExists('komponen_models');
    }
}
