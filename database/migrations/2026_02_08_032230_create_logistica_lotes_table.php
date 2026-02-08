<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticaLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('logistica_lotes', function (Blueprint $table) {
        $table->id();
        $table->string('cod_log')->unique();
        $table->string('carpeta')->nullable();
        $table->string('estado')->default('Pendiente');
        $table->string('responsable')->nullable();
        $table->string('numero_carta')->nullable();
        $table->text('asunto')->nullable();
        $table->date('fecha_emision')->nullable();
        $table->string('codigo_unico')->nullable();
        $table->string('atencion')->nullable();
        $table->text('observacion')->nullable();
        $table->string('tipo_solicitud')->nullable();
        $table->string('nro_oc_os')->nullable();
        $table->date('emision_oc_os')->nullable();
        // Auditoría
        $table->foreignId('created_by')->nullable()->constrained('users');
        $table->foreignId('updated_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('logistica_lotes');
    }
}
