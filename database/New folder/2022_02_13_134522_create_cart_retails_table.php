<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_retails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_item');
            $table->string('jumlah');
            $table->string('harga_pk');
            $table->string('margin');
            $table->string('harga_up');
            $table->string('disc');
            $table->string('cut_sale');
            $table->string('subtotal_pk');
            $table->string('subtotal_up');
            $table->integer('cabang_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('cart_retails');
    }
}
