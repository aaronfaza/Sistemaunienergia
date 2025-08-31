<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;

    protected $table = 'requerimientos';

    protected $fillable = [
        'codigo',
        'fecha',
        'area_solicitante',
        'nombre_solicitante',
        'cargo_solicitante',
        'servicio',
        'destino',
        'sustento',
    ];

    // Relación con los detalles
    public function detalles()
    {
        return $this->hasMany(DetalleRequerimiento::class, 'requerimiento_id');
    }
}
