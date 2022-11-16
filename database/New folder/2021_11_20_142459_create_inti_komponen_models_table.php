<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntiKomponenModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inti_komponen_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_komponen');
            $table->integer('total_hpp');
            $table->integer('total_harga_jual');
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
        Schema::dropIfExists('inti_komponen_models');
    }
}
