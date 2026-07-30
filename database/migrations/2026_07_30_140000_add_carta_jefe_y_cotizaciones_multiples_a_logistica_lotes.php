<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            // Carta del área solicitante = archivo_carta (ya existente). Esta es
            // la segunda carta, requerida cuando la compra/servicio supera los
            // US$ 1,000 (regla que decide quien registra el ROP, no se valida
            // automáticamente porque depende de montos en distinta moneda).
            $table->string('archivo_carta_jefe_operaciones')->nullable()->after('archivo_carta');

            // Reemplaza archivo_cotizacion (columna única) por hasta 6 slots,
            // ya que en la práctica puede haber entre 1 y 6 cotizaciones.
            $table->string('archivo_cotizacion_1')->nullable()->after('archivo_carta_jefe_operaciones');
            $table->string('archivo_cotizacion_2')->nullable()->after('archivo_cotizacion_1');
            $table->string('archivo_cotizacion_3')->nullable()->after('archivo_cotizacion_2');
            $table->string('archivo_cotizacion_4')->nullable()->after('archivo_cotizacion_3');
            $table->string('archivo_cotizacion_5')->nullable()->after('archivo_cotizacion_4');
            $table->string('archivo_cotizacion_6')->nullable()->after('archivo_cotizacion_5');
        });

        // Preserva cualquier cotización ya subida bajo el esquema anterior.
        DB::table('logistica_lotes')
            ->whereNotNull('archivo_cotizacion')
            ->update(['archivo_cotizacion_1' => DB::raw('archivo_cotizacion')]);

        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn('archivo_cotizacion');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->string('archivo_cotizacion')->nullable()->after('archivo_carta');
        });

        DB::table('logistica_lotes')
            ->whereNotNull('archivo_cotizacion_1')
            ->update(['archivo_cotizacion' => DB::raw('archivo_cotizacion_1')]);

        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn([
                'archivo_carta_jefe_operaciones',
                'archivo_cotizacion_1', 'archivo_cotizacion_2', 'archivo_cotizacion_3',
                'archivo_cotizacion_4', 'archivo_cotizacion_5', 'archivo_cotizacion_6',
            ]);
        });
    }
};
