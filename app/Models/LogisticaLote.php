<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticaLote extends Model
{
    use HasFactory, Auditable;

    protected $table = 'logistica_lotes'; // Forzamos el nombre de la tabla

    // carta_type/carta_id quedan fuera a propósito: se setean explícitamente en el
    // controller (nunca vía mass-assignment) porque determinan el vínculo legal con
    // la carta de origen y solo el rol admin puede definirlos, una sola vez.
    protected $fillable = [
        'cod_log', 'carpeta', 'estado', 'servicio_valorizacion', 'responsable', 'numero_carta',
        'asunto', 'fecha_emision', 'codigo_unico', 'atencion',
        'observacion', 'tipo_solicitud', 'nro_oc_os', 'emision_oc_os', 'conformidad', 'factura',
        'ruc', 'empresa_ganadora', 'centro_costo', 'moneda', 'monto_igv', 'forma_pago',
        'fecha_entrega', 'orden_firmada', 'ejecucion', 'porcentaje_ejecucion', 'monto_factura',
        'fecha_vencimiento', 'fecha_pago',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'emision_oc_os' => 'date',
        'fecha_entrega' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'orden_firmada' => 'boolean',
        'monto_igv' => 'decimal:2',
        'monto_factura' => 'decimal:2',
    ];

    // Catálogos reales tomados del registro de Logística (hoja "SOLICITUDES DE AREA
    // USUARIA - OPE/SP 2026"), no inventados — mantener sincronizado con lo que el
    // equipo usa de verdad para que el desplegable no quede desactualizado.
    const ESTADOS = [
        'PENDIENTE', 'EN REVISION', 'BUENA PRO', 'EN PROCESO', 'EN EJECUCION',
        'EJECUTADO', 'OBSERVADO', 'ORDEN VENCIDA', 'ANULADO',
    ];

    const TIPOS_SOLICITUD = ['SERVICIO', 'COMPRA LOCAL', 'HONORARIOS'];

    const MONEDAS = ['SOLES', 'USD'];

    const EJECUCIONES = ['PARCIAL', 'TOTAL'];

    const FORMAS_PAGO = [
        'CONTADO',
        'CREDITO A 15 DIAS',
        'CREDITO A 30 DIAS',
        'CREDITO A 45 DIAS',
        'CREDITO A 60 DIAS',
        '50% ADELANTO 50% CONTRAENTREGA',
        'OTRO',
    ];

    public function carta()
    {
        return $this->morphTo();
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modificador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
