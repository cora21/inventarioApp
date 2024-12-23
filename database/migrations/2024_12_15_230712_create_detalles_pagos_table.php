<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('metodo_pago_id')->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_pagos');
    }
}
