<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anomalia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'pozo',
        'tipo_equipo',
        'gravedad',
        'descripcion',
        'foto',
        'estado',
    ];
}
