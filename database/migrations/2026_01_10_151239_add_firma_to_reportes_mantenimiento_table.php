<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->string('firma')->nullable()->after('foto'); // o donde prefieras
        });
    }

    public function down(): void
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->dropColumn('firma');
        });
    }
};
