<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTituloToReportesMantenimientoTable extends Migration
{
    public function up()
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->string('titulo')->nullable()->after('nombre');
        });
    }

    public function down()
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->dropColumn('titulo');
        });
    }
}