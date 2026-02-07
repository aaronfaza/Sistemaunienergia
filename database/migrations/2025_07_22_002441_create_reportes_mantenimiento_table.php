<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesMantenimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_mantenimiento', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->date('fecha_inicio');
    $table->date('fecha_termino');
    $table->string('tipo_equipo');
    $table->string('ubicacion');
    $table->string('rotulado');
    $table->json('herramientas');
    $table->json('materiales');
    $table->text('descripcion_actividad');
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
        Schema::dropIfExists('reportes_mantenimiento');
    }
}
