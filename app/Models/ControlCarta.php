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
        'area'
    ];

    // Ejemplo de relación con usuarios (si el usuario genera las cartas)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'autorizado_por', 'name');
    }
}
