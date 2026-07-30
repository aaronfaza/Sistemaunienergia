<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cartas_ipf', function (Blueprint $table) {
            $table->string('archivo_carta')->nullable()->after('updated_by');
            $table->string('archivo_cotizacion')->nullable()->after('archivo_carta');
            $table->string('archivo_requerimiento')->nullable()->after('archivo_cotizacion');
            $table->string('carpeta_rop')->nullable()->after('archivo_requerimiento');
            $table->boolean('firmado_verificado')->default(false)->after('carpeta_rop');
            $table->foreignId('verificado_por')->nullable()->after('firmado_verificado')->constrained('users')->nullOnDelete();
            $table->timestamp('verificado_en')->nullable()->after('verificado_por');
        });
    }

    public function down(): void
    {
        Schema::table('cartas_ipf', function (Blueprint $table) {
            $table->dropForeign(['verificado_por']);
            $table->dropColumn([
                'archivo_carta', 'archivo_cotizacion', 'archivo_requerimiento',
                'carpeta_rop', 'firmado_verificado', 'verificado_por', 'verificado_en',
            ]);
        });
    }
};
