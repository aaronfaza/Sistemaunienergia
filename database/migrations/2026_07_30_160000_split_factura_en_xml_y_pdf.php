<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn('archivo_factura');
        });

        Schema::table('logistica_lotes', function (Blueprint $table) {
            // La factura electrónica real son 2 archivos: el XML (documento
            // legal) y su representación impresa en PDF.
            $table->string('archivo_factura_xml')->nullable()->after('archivo_conformidad');
            $table->string('archivo_factura_pdf')->nullable()->after('archivo_factura_xml');
        });
    }

    public function down(): void
    {
        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->dropColumn(['archivo_factura_xml', 'archivo_factura_pdf']);
        });

        Schema::table('logistica_lotes', function (Blueprint $table) {
            $table->string('archivo_factura')->nullable()->after('archivo_conformidad');
        });
    }
};
