<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicereturnsupplierModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicereturnsupplier_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_return');
            $table->string('no_invoice');
            $table->date('tgl_return');
            $table->date('tgl_invoice');
            $table->integer('id_supplier');
            $table->integer('sub_total');
            $table->integer('tax');
            $table->integer('big_total');
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
        Schema::dropIfExists('invoicereturnsupplier_models');
    }
}
