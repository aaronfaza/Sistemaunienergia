<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRequerimiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_requerimientos';

    protected $fillable = [
        'requerimiento_id',
        'identificacion',
        'cantidad',
        'unidad',
        'descripcion',
    ];

    // Relación inversa
    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'requerimiento_id');
    }
}
