<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_purchase');
            $table->integer('id_user');
            $table->string('purchasers');
            $table->date('tanggal_purchase');
            $table->string('nama_gudang');
            $table->date('due_date');
            $table->string('status');
            $table->integer('big_total');
            $table->integer('bayar');
            $table->integer('sisa');
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
        Schema::dropIfExists('purchasing_models');
    }
}
