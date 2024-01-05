<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_retails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_item');
            $table->integer('id_item');
            $table->string('harga_pk');
            $table->string('margin');
            $table->string('harga_up');
            $table->string('qty');
            $table->string('subtotal_pk');
            $table->string('subtotal_up');
            $table->integer('cabang_id');
            $table->integer('user_id');
            $table->date('tanggal_return');
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
        Schema::dropIfExists('return_retails');
    }
}
