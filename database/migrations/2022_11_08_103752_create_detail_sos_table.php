<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_order');
            $table->integer('id_produk');
            $table->string('modal');
            $table->string('jual');
            $table->integer('jumlah');
            $table->string('sub_modal');
            $table->string('sub_jual');
            $table->string('status');
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
        Schema::dropIfExists('detail_sos');
    }
}
