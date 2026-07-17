<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerfilAUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('direccion')->nullable()->after('cargo');
            $table->string('foto_perfil')->nullable()->after('direccion');
            $table->date('fecha_nacimiento')->nullable()->after('foto_perfil');
            $table->date('fecha_ingreso')->nullable()->after('fecha_nacimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['direccion', 'foto_perfil', 'fecha_nacimiento', 'fecha_ingreso']);
        });
    }
}
