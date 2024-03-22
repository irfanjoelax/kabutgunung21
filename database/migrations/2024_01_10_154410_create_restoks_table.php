<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restoks', function (Blueprint $table) {
            $table->id();
            $table->uuid('produk_id');
            $table->unsignedInteger('harga_awal');
            $table->unsignedInteger('harga_akhir');
            $table->unsignedInteger('stok_awal');
            $table->unsignedInteger('restok');
            $table->timestamps();

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
        Schema::dropIfExists('restoks');
    }
}
