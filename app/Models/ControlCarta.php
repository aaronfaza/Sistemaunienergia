<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCarta extends Model
{
    use HasFactory, Auditable;

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
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_recepcion' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'monto_soles' => 'decimal:2',
        'monto_dolares' => 'decimal:2',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modificador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function ropLote()
    {
        return $this->morphOne(LogisticaLote::class, 'carta');
    }
}
