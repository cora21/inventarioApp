<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTasaCambioIdToDetallesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('detalles_pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('tasa_cambio_id')->nullable()->after('metodo_pago_id');
            $table->foreign('tasa_cambio_id')->references('id')->on('tasas_cambios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_pagos', function (Blueprint $table) {
            //
        });
    }
}
