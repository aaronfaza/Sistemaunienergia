<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReporteMantenimiento extends Model
{
    use HasFactory;

    // ✅ Nombre correcto de la tabla
    protected $table = 'reportes_mantenimiento';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'titulo',
        'fecha_inicio',
        'fecha_termino',
        'tipo_equipo',
        'ubicacion',
        'rotulado',
        'herramientas',
        'materiales',
        'descripcion_actividad',
        'foto',
        'firma',
        
    ];

    // Definir que herramientas y materiales son arrays (JSON en base de datos)
    protected $casts = [
        'herramientas' => 'array',
        'materiales' => 'array',
    ];
}
