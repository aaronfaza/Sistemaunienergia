<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticaLote extends Model
{
    use HasFactory;

    protected $table = 'logistica_lotes'; // Forzamos el nombre de la tabla

    protected $fillable = [
    'cod_log', 'carpeta', 'estado', 'responsable', 'numero_carta', 'asunto',
    'fecha_emision', 'codigo_unico', 'atencion', 'observacion', 'tipo_solicitud',
    'nro_oc_os', 'emision_oc_os', 'conformidad', 'factura', 'ruc', 'empresa_ganadora',
    'centro_costo', 'moneda', 'monto_igv', 'forma_pago', 'fecha_entrega',
    'orden_firmada', 'ejecucion', 'porcentaje_ejecucion', 'monto_factura', 'fecha_vencimiento',
    'created_by', 'updated_by'
];
}