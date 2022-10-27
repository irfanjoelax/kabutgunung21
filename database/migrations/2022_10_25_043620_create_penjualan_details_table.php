<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('penjualan_id');
            $table->uuid('produk_id');
            $table->unsignedInteger('hrg_jual');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('total');
            $table->timestamps();

            $table->foreign('penjualan_id')->references('id')->on('penjualans');
            $table->foreign('produk_id')->references('id')->on('produks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_details');
    }
}
