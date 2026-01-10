<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaFis extends Model
{
    use HasFactory;

    protected $table = 'cartas_fis';

    protected $fillable = [
        'codigo','fecha','mes','area',
        'servicio_compra','descripcion',
        'proveedor_elegido','cotizaciones_consideradas',
        'equipo','especificacion',
        'monto_soles','monto_dolares',
        'nro_orden','autorizado_por',
        'factura_nro','fecha_recepcion','fecha_vencimiento','fecha_pago',
        'estado',
        'created_by','updated_by'
    ];
}

