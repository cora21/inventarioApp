<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('producto_almacen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('almacen_id');
            $table->integer('cantidad')->default(0); // Cantidad de este producto en el almacén
            $table->timestamps();

            // Relaciones
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');

            // Clave única para evitar duplicados en la relación
            $table->unique(['producto_id', 'almacen_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('producto_almacen');
    }
}