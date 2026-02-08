<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            // Agregamos todos los campos nuevos como nullable para no romper registros viejos
            $table->string('conformidad')->nullable()->after('emision_oc_os');
            $table->string('factura')->nullable()->after('conformidad');
            $table->string('ruc', 11)->nullable()->after('factura');
            $table->string('empresa_ganadora')->nullable()->after('ruc');
            $table->string('centro_costo')->nullable()->after('empresa_ganadora');
            $table->string('moneda', 20)->nullable()->after('centro_costo');
            $table->decimal('monto_igv', 15, 2)->nullable()->after('moneda');
            $table->string('forma_pago')->nullable()->after('monto_igv');
            $table->date('fecha_entrega')->nullable()->after('forma_pago');
            $table->boolean('orden_firmada')->default(false)->after('fecha_entrega');
            $table->string('ejecucion')->nullable()->after('orden_firmada');
            $table->integer('porcentaje_ejecucion')->nullable()->after('ejecucion');
            $table->decimal('monto_factura', 15, 2)->nullable()->after('porcentaje_ejecucion');
            $table->date('fecha_vencimiento')->nullable()->after('monto_factura');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn([
                'conformidad', 'factura', 'ruc', 'empresa_ganadora', 
                'centro_costo', 'moneda', 'monto_igv', 'forma_pago', 
                'fecha_entrega', 'orden_firmada', 'ejecucion', 
                'porcentaje_ejecucion', 'monto_factura', 'fecha_vencimiento'
            ]);
        });
    }
};