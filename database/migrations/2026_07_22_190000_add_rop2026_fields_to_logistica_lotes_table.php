<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->string('servicio_valorizacion')->nullable()->after('estado');
            $table->date('fecha_pago')->nullable()->after('fecha_vencimiento');
            $table->string('carta_type')->nullable()->after('numero_carta');
            $table->unsignedBigInteger('carta_id')->nullable()->after('carta_type');

            $table->unique(['carta_type', 'carta_id'], 'logistica_lotes_carta_unique');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropUnique('logistica_lotes_carta_unique');
            $table->dropColumn(['servicio_valorizacion', 'fecha_pago', 'carta_type', 'carta_id']);
        });
    }
};
