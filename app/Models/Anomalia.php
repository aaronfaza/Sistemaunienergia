<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anomalia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha',
        'pozo',
        'tipo_equipo',
        'gravedad',
        'descripcion',
        'sugerencia',
        'foto',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
}
