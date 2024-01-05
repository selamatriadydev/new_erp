<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePeminjamanModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_peminjaman_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_peminjaman');
            $table->integer('id_cabang');
            $table->integer('id_peminjam');
            $table->date('tanggal_peminjam');
            $table->date('due_date');
            $table->integer('big_total');
            $table->integer('bayar');
            $table->integer('sisa');
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
        Schema::dropIfExists('invoice_peminjaman_models');
    }
}
