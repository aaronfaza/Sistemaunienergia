<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->string('archivo_carta')->nullable()->after('observacion');
            $table->string('archivo_cotizacion')->nullable()->after('archivo_carta');
            $table->string('archivo_requerimiento')->nullable()->after('archivo_cotizacion');
            $table->boolean('firmado_verificado')->default(false)->after('archivo_requerimiento');
            $table->foreignId('verificado_por')->nullable()->after('firmado_verificado')->constrained('users')->nullOnDelete();
            $table->timestamp('verificado_en')->nullable()->after('verificado_por');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropForeign(['verificado_por']);
            $table->dropColumn([
                'archivo_carta', 'archivo_cotizacion', 'archivo_requerimiento',
                'firmado_verificado', 'verificado_por', 'verificado_en',
            ]);
        });
    }
};
