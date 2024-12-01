<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosColoresTable extends Migration{

    public function up()
    {
        Schema::create('productos_colores', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Relación con productos
            $table->foreignId('color_id')->constrained('colores')->onDelete('cascade'); // Relación con colores
            $table->integer('unidadesDisponibleProducto')->default(0); // Cantidad de productos del color
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_colores');
    }
}
