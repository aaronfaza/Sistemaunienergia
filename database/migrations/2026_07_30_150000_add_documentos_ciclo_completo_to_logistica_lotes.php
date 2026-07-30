<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            // 03 EVALUACION (junto a archivo_acta_comite, cuando la compra
            // supera US$ 1,000): certificación presupuestal, firmada por el
            // Gerente de Administración y Finanzas.
            $table->string('archivo_certificacion_presupuestal')->nullable()->after('archivo_acta_comite');

            // 05 INFORMES / 05 GRE: solo uno de los dos aplica, según
            // tipo_solicitud (servicio → informe, compra → GRE).
            $table->string('archivo_informe')->nullable()->after('archivo_orden');
            $table->string('archivo_gre')->nullable()->after('archivo_informe');

            // 06 CONFORMIDAD y 07 FACTURA.
            $table->string('archivo_conformidad')->nullable()->after('archivo_gre');
            $table->string('archivo_factura')->nullable()->after('archivo_conformidad');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn([
                'archivo_certificacion_presupuestal',
                'archivo_informe', 'archivo_gre',
                'archivo_conformidad', 'archivo_factura',
            ]);
        });
    }
};
