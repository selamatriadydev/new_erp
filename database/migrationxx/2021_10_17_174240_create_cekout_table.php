<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCekoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cekout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_inv');
            $table->integer('id_paket');
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('disc');
            $table->integer('cut_sale');
            $table->integer('subtotal');
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
        Schema::dropIfExists('cekout');
    }
}
