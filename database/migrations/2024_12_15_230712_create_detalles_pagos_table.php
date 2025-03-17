<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('descripcionPago')->nullable();
            $table->string('nombrePago')->nullable();
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pagos');
        });
        // Crear el trigger después de insertar en la tabla `detalles_pagos`
    DB::unprepared('
        CREATE TRIGGER after_insert_detalles_pagos AFTER INSERT ON `detalles_pagos`
        FOR EACH ROW BEGIN
            -- Verificar si esta venta_id ya fue procesada dentro del conjunto actual
            IF NOT EXISTS (
                SELECT 1
                FROM detalles_pagos dp
                WHERE dp.venta_id = NEW.venta_id
                    AND dp.id < NEW.id
            ) THEN
                -- Actualizar los productos basados en la venta_id
                UPDATE productos p
                JOIN (
                    SELECT
                        dv.producto_id,
                        SUM(dv.cantidadSeleccionadaVenta) AS total_cantidad
                    FROM detalles_ventas dv
                    WHERE dv.venta_id = NEW.venta_id
                    GROUP BY dv.producto_id
                ) AS cantidades
                ON p.id = cantidades.producto_id
                SET p.cantidadDisponibleProducto = p.cantidadDisponibleProducto - cantidades.total_cantidad;
            END IF;
        END
    ');

            // Crear el trigger `after_insert_productos_colores`
            DB::unprepared('
            CREATE TRIGGER after_insert_productos_colores AFTER INSERT ON `detalles_pagos`
            FOR EACH ROW BEGIN
                -- Verificar si esta venta_id ya fue procesada dentro del conjunto actual
                IF NOT EXISTS (
                    SELECT 1
                    FROM detalles_pagos dp
                    WHERE dp.venta_id = NEW.venta_id
                    AND dp.id < NEW.id
                ) THEN
                    -- Actualizar el inventario por color basado en la venta_id
                    UPDATE productos_colores pc
                    JOIN (
                        SELECT
                            dv.producto_id,
                            dv.color_id,
                            SUM(dv.cantidadSeleccionadaVenta) AS total_cantidad
                        FROM detalles_ventas dv
                        WHERE dv.venta_id = NEW.venta_id
                        GROUP BY dv.producto_id, dv.color_id
                    ) AS cantidades
                    ON pc.producto_id = cantidades.producto_id AND pc.color_id = cantidades.color_id
                    SET pc.unidadesDisponibleProducto = pc.unidadesDisponibleProducto - cantidades.total_cantidad;
                END IF;
            END
        ');
}
    
        public function down(){
            // Eliminar el trigger antes de eliminar la tabla
            DB::unprepared('DROP TRIGGER IF EXISTS after_insert_detalles_pagos');
            DB::unprepared('DROP TRIGGER IF EXISTS after_insert_productos_colores');
            Schema::dropIfExists('detalles_pagos');
        }
}
