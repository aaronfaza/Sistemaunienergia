<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnomaliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anomalias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('pozo');
            $table->string('tipo_equipo');
            $table->string('gravedad')->default('Media');
            $table->text('descripcion');
            $table->string('foto')->nullable();
            $table->string('estado')->default('Pendiente');
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
        Schema::dropIfExists('anomalias');
    }
}
