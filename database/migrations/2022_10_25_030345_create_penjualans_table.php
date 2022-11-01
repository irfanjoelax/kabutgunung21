<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_pesanan')->nullable();
            $table->uuid('marketplace_id')->nullable();
            $table->string('kurir', 100)->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status_kurir', 50)->nullable();
            $table->unsignedInteger('modal')->nullable();
            $table->unsignedInteger('total')->nullable();
            $table->unsignedInteger('fee')->nullable();
            $table->unsignedInteger('grand_total')->nullable();
            $table->string('status_bayar', 50)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('marketplace_id')->references('id')->on('marketplaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
