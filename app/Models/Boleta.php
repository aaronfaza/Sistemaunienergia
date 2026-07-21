<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo',
        'periodo',
        'archivo',
        'subido_por',
        'confirmado_en',
    ];

    protected $casts = [
        'confirmado_en' => 'datetime',
    ];

    const TIPOS = [
        'mensual' => 'Mensual',
        'cts' => 'CTS',
        'gratificacion' => 'Gratificación',
    ];

    const MESES = [
        '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
        '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
        '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
    ];

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTipoLabelAttribute()
    {
        return self::TIPOS[$this->tipo] ?? 'Mensual';
    }

    public function getPeriodoFormateadoAttribute()
    {
        [$anio, $mes] = array_pad(explode('-', (string) $this->periodo), 2, null);

        if (!$anio || !$mes || !isset(self::MESES[$mes])) {
            return $this->periodo;
        }

        return self::MESES[$mes].' '.$anio;
    }
}
