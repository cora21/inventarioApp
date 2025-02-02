<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasasCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('tasas_cambios', function (Blueprint $table) {
            $table->id();
            $table->string('nombreMoneda')->nullable();
            $table->string('valorMoneda')->nullable();
            $table->string('baseMoneda')->nullable();
            $table->timestamps();
        });

        DB::unprepared('
            CREATE TRIGGER after_tasas_cambios_update AFTER UPDATE ON `tasas_cambios`
            FOR EACH ROW BEGIN
                -- Verifica si el id es 2 y el campo valorMoneda ha cambiado
                IF OLD.valorMoneda <> NEW.valorMoneda AND NEW.id = 2 THEN
                    -- Inserta el historial en la tabla historial_tasas_cambios
                    INSERT INTO historial_tasas_cambios (nombreMonedaH, valorMonedaH, fechavalorH)
                    VALUES ("VES", NEW.valorMoneda, NEW.updated_at);
                END IF;
            END
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        // Eliminar el trigger antes de eliminar la tabla
        DB::unprepared('DROP TRIGGER IF EXISTS after_tasas_cambios_update');
        Schema::dropIfExists('tasas_cambios');
    }
}
