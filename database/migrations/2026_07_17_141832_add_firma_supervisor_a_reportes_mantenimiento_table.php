<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirmaSupervisorAReportesMantenimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->unsignedBigInteger('firmado_supervisor_id')->nullable()->after('firma');
            $table->timestamp('firmado_supervisor_en')->nullable()->after('firmado_supervisor_id');

            $table->foreign('firmado_supervisor_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reportes_mantenimiento', function (Blueprint $table) {
            $table->dropForeign(['firmado_supervisor_id']);
            $table->dropColumn(['firmado_supervisor_id', 'firmado_supervisor_en']);
        });
    }
}
