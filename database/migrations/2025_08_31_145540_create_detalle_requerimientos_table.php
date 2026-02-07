<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                Schema::create('detalle_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requerimiento_id')
                ->constrained('requerimientos')
                ->onDelete('cascade');

            $table->string('identificacion');  // IDEN
            $table->integer('cantidad');       // CANT
            $table->string('unidad');          // UNID
            $table->text('descripcion');       // detalle del ítem
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
        Schema::dropIfExists('detalle_requerimientos');
    }
}
