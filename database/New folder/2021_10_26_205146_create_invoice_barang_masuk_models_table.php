<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceBarangMasukModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_barang_masuk_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_receive');
            $table->string('no_invoice');
            $table->date('tgl_terima');
            $table->date('tgl_invoice');
            $table->integer('id_supplier');
            $table->date('due_date');
            $table->integer('sub_total');
            $table->integer('tax');
            $table->integer('big_total');
            $table->integer('dp');
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
        Schema::dropIfExists('invoice_barang_masuk_models');
    }
}
