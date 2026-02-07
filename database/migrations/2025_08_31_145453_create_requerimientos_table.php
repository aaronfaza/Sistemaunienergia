<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id(); // id_requerimiento
            $table->string('codigo')->unique(); // REQ-2024
            $table->date('fecha');              // fecha del requerimiento
            $table->string('area_solicitante'); // área
            $table->string('nombre_solicitante');
            $table->string('cargo_solicitante');
            $table->string('servicio')->nullable();   // servicio asociado
            $table->string('destino')->nullable();    // destino (ej: Ing. Producción)
            $table->text('sustento')->nullable();     // justificación
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
        Schema::dropIfExists('requerimientos');
    }
}
