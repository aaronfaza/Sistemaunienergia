<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cartas_fis', function (Blueprint $table) {
            $table->id();

            // Datos principales
            $table->string('codigo')->unique();
            $table->date('fecha');
            $table->string('mes')->nullable();
            $table->string('area')->nullable();

            $table->string('servicio_compra');
            $table->text('descripcion')->nullable();

            $table->string('proveedor_elegido')->nullable();
            $table->string('cotizaciones_consideradas')->nullable();

            $table->string('equipo')->nullable();
            $table->string('especificacion')->nullable();

            $table->decimal('monto_soles', 12, 2)->nullable();
            $table->decimal('monto_dolares', 12, 2)->nullable();

            $table->string('nro_orden')->nullable();
            $table->string('autorizado_por')->nullable();

            $table->string('factura_nro')->nullable();
            $table->date('fecha_recepcion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_pago')->nullable();

            // Estado de fiscalización
            $table->enum('estado', ['Pendiente', 'Rechazado', 'Ejecutado'])
                  ->default('Pendiente');

            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cartas_fis');
    }
};
