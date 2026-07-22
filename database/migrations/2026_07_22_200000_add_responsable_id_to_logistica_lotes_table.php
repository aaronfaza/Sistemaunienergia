<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            // Quien tiene pendiente firmar el documento (orden de compra o
            // conformidad) del expediente. Distinto de `responsable` (string
            // libre, en desuso) y de `atencion` (quien procesa la orden).
            $table->foreignId('responsable_id')->nullable()->after('atencion')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropColumn('responsable_id');
        });
    }
};
