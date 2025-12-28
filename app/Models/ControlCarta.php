<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCarta extends Model
{
    use HasFactory;

    protected $table = 'control_cartas';

    protected $fillable = [
        'codigo',
        'fecha',
        'mes',
        'servicio_compra',
        'descripcion',
        'proveedor_elegido',
        'cotizaciones_consideradas',
        'equipo',
        'especificacion',
        'monto_soles',
        'monto_dolares',
        'nro_orden',
        'autorizado_por',
        'factura_nro',
        'fecha_recepcion',
        'fecha_vencimiento',
        'fecha_pago',
        'area',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_recepcion' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'monto_soles' => 'decimal:2',
        'monto_dolares' => 'decimal:2',
    ];
}
