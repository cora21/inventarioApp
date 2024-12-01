<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreProducto')->nullable();
            $table->string('marcaProducto')->nullable();
            $table->string('modeloProducto')->nullable();
            $table->text('descripcionProducto')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->unsignedBigInteger('almacen_id')->nullable(); // Aunque será usado en la intermedia, lo incluimos por integridad.
            $table->integer('cantidadDisponibleProducto')->default(0);
            $table->decimal('precioUnitarioProducto', 10, 2)->nullable();
            $table->decimal('precioTotal', 15, 2)->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
