<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedInteger('cantidadSeleccionadaVenta')->nullable();
            $table->unsignedBigInteger('color_id')->nullable()->nullable();
            $table->decimal('precioUnitarioProducto', 10, 2)->nullable();
            $table->decimal('precioTotalPorVenta', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('color_id')->references('id')->on('colores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_ventas');
    }
}
