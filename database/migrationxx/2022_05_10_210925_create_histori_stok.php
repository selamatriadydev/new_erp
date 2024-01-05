<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_stok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_item');
            $table->string('hargapk');
            $table->string('hargaup');
            $table->string('jumlah');
            $table->string('subtotalpk');
            $table->string('subtotalup');
            $table->integer('cabang_id');
            $table->date('tgl_stok');
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
        Schema::dropIfExists('histori_stok');
    }
}
