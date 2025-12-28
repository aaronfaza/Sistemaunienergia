<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('control_cartas', function (Blueprint $table) {
            $table->enum('estado', ['Pendiente', 'Rechazado', 'Ejecutado'])
                  ->default('Pendiente')
                  ->after('area'); // si quieres ubicarlo después de "area"
        });
    }

    public function down(): void
    {
        Schema::table('control_cartas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
