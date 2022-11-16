<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchProdModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purch_prod_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_purchase');
            $table->integer('id_bahanbaku');
            $table->integer('berat');
            $table->integer('id_satuan');
            $table->integer('harga_pk');
            $table->integer('harga');
            $table->integer('quantity');
            $table->integer('sub_total');
            $table->string('status');
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
        Schema::dropIfExists('purch_prod_models');
    }
}
