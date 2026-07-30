<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->string('archivo_orden')->nullable()->after('nro_oc_os');
            $table->string('archivo_acta_comite')->nullable()->after('archivo_requerimiento');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn(['archivo_orden', 'archivo_acta_comite']);
        });
    }
};
