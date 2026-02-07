<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlCartasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('control_cartas', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->date('fecha');
        $table->string('mes')->nullable();
        $table->string('servicio_compra')->nullable();
        $table->text('descripcion')->nullable();
        $table->string('proveedor_elegido')->nullable();
        $table->string('cotizaciones_consideradas')->nullable();
        $table->string('equipo')->nullable();
        $table->text('especificacion')->nullable();
        $table->decimal('monto_soles', 10, 2)->nullable();
        $table->decimal('monto_dolares', 10, 2)->nullable();
        $table->string('nro_orden')->nullable();
        $table->string('autorizado_por')->nullable();
        $table->string('factura_nro')->nullable();
        $table->date('fecha_recepcion')->nullable();
        $table->date('fecha_vencimiento')->nullable();
        $table->date('fecha_pago')->nullable();
        $table->string('area')->default('SO-PRO');
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
        Schema::dropIfExists('control_cartas');
    }
}
