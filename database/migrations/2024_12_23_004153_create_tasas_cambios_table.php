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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasas_cambios');
    }
}
