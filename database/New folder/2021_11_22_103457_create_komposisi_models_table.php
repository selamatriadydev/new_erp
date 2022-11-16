<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomposisiModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komposisi_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_resep');
            $table->integer('id_bahanbaku');
            $table->integer('harga_up');
            $table->integer('quantity');
            $table->string('total_harga_up');
            $table->integer('hasil_jadi');
            $table->string('gramasi');
            $table->integer('id_satuan');
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
        Schema::dropIfExists('komposisi_models');
    }
}
