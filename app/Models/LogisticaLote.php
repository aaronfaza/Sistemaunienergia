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
        'asunto', 'fecha_emision', 'codigo_unico', 'atencion', 'responsable_id',
        'observacion', 'tipo_solicitud', 'nro_oc_os', 'emision_oc_os', 'conformidad', 'factura',
        'ruc', 'empresa_ganadora', 'centro_costo', 'moneda', 'monto_igv', 'forma_pago',
        'fecha_entrega', 'orden_firmada', 'ejecucion', 'porcentaje_ejecucion', 'monto_factura',
        'fecha_vencimiento', 'fecha_pago',
        'archivo_carta', 'archivo_carta_jefe_operaciones', 'archivo_requerimiento',
        'archivo_orden', 'archivo_acta_comite', 'archivo_certificacion_presupuestal',
        'archivo_informe', 'archivo_gre', 'archivo_conformidad', 'archivo_factura',
        'archivo_cotizacion_1', 'archivo_cotizacion_2', 'archivo_cotizacion_3',
        'archivo_cotizacion_4', 'archivo_cotizacion_5', 'archivo_cotizacion_6',
    ];

    // Slots de cotización disponibles (1 a 6, según la cantidad real que se
    // reciba por proceso de compra/servicio).
    public const COTIZACION_SLOTS = 6;

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

    /**
     * Usuario que tiene pendiente firmar el documento (orden de compra o
     * conformidad) de este expediente.
     */
    public function responsableFirma()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Rutas de las cotizaciones realmente subidas (ignora los slots vacíos),
     * para no listar 6 casillas "No subido" cuando solo hay 1 o 2 reales.
     */
    public function cotizacionesSubidas(): array
    {
        $rutas = [];

        for ($i = 1; $i <= self::COTIZACION_SLOTS; $i++) {
            $ruta = $this->{"archivo_cotizacion_{$i}"};
            if ($ruta) {
                $rutas["cotizacion_{$i}"] = $ruta;
            }
        }

        return $rutas;
    }

    public function verificadoPor()
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }

    /**
     * Indicadores de gestión de ROP2026 Lote IX (KPIs + series para
     * gráficas). Única fuente de verdad usada tanto por la hoja "Dashboard"
     * del backup Excel como por el panel de Bienvenida del rol logística,
     * para no duplicar la misma lógica de negocio en dos lugares.
     */
    public static function estadisticasGenerales(): array
    {
        $registros = static::orderBy('id')->get();
        $total = $registros->count();

        $porEstado = collect(self::ESTADOS)->mapWithKeys(function ($estado) use ($registros) {
            return [$estado => $registros->where('estado', $estado)->count()];
        });

        $ejecutados = $porEstado['EJECUTADO'] ?? 0;
        $anulados = $porEstado['ANULADO'] ?? 0;
        $vencidosObservados = ($porEstado['ORDEN VENCIDA'] ?? 0) + ($porEstado['OBSERVADO'] ?? 0);
        $enProceso = $total - $ejecutados - $anulados - $vencidosObservados;
        $pendientes = $total - $ejecutados - $anulados;

        $pct = fn (int $parte) => $total > 0 ? round($parte / $total * 100, 1) : 0.0;

        $promedioAvance = $total > 0
            ? round($registros->avg(fn ($r) => $r->porcentaje_ejecucion ?? 0), 1)
            : 0.0;

        $anioActual = now()->year;
        $porMes = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $porMes[$mes] = $registros->filter(function ($r) use ($anioActual, $mes) {
                return $r->created_at && $r->created_at->year === $anioActual && $r->created_at->month === $mes;
            })->count();
        }

        return [
            'total' => $total,
            'por_estado' => $porEstado,
            'ejecutados' => $ejecutados,
            'anulados' => $anulados,
            'vencidos_observados' => $vencidosObservados,
            'en_proceso' => $enProceso,
            'pendientes' => $pendientes,
            'pct_ejecutados' => $pct($ejecutados),
            'pct_pendientes' => $pct($pendientes),
            'pct_vencidos' => $pct($vencidosObservados),
            'promedio_avance' => $promedioAvance,
            'anio_actual' => $anioActual,
            'por_mes' => $porMes,
            'avance_por_expediente' => $registros->map(fn ($r) => [
                'cod_log' => $r->cod_log,
                'porcentaje' => $r->porcentaje_ejecucion ?? 0,
            ])->values(),
        ];
    }
}
