<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte_{{ $lote->cod_log }}</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }
        /* Encabezado */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo { width: 180px; }
        .company-name {
            color: #003366;
            font-size: 16pt;
            font-weight: bold;
            text-align: right;
        }
        .report-title {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        /* Bloques de Información */
        .section-title {
            background-color: #003366;
            color: white;
            padding: 5px 10px;
            font-size: 9pt;
            font-weight: bold;
            margin-top: 12px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .info-table td {
            padding: 6px 8px;
            border: 1px solid #eee;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #555;
            font-size: 8pt;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }
        .value {
            font-size: 10pt;
            color: #000;
        }

        /* Estado y Ejecución */
        .status-badge {
            padding: 2px 8px;
            border-radius: 5px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }
        .status-finalizado { background-color: #d1fae5; color: #047857; }
        .status-proceso { background-color: #fef3c7; color: #b45309; }
        
        .progress-container {
            background-color: #eee;
            border-radius: 4px;
            width: 100%;
            height: 10px;
            margin-top: 5px;
        }
        .progress-bar {
            background-color: #2563eb;
            height: 10px;
            border-radius: 4px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 7pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            text-align: right;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <img src="{{ public_path('img/Logo1.png') }}" class="logo">
            </td>
            <td class="company-name">
                Unienergia ABC SAC <br>
                <span style="font-size: 8pt; color: #666;">Control Logístico - Operaciones Lote IX</span>
            </td>
        </tr>
    </table>

    <div class="report-title">
        Ficha Detallada de Seguimiento: {{ $lote->cod_log }}
    </div>

    <div class="section-title">1. DATOS DE IDENTIFICACIÓN</div>
    <table class="info-table">
        <tr>
            <td width="25%">
                <span class="label">Cod. Logística</span>
                <span class="value"><strong>{{ $lote->cod_log }}</strong></span>
            </td>
            <td width="25%">
                <span class="label">Carpeta / Lote</span>
                <span class="value">{{ $lote->carpeta }}</span>
            </td>
            <td width="25%">
                <span class="label">Estado</span>
                <span class="status-badge {{ $lote->estado == 'Finalizado' ? 'status-finalizado' : 'status-proceso' }}">
                    {{ strtoupper($lote->estado) }}
                </span>
            </td>
            <td width="25%">
                <span class="label">F. Emisión</span>
                <span class="value">{{ $lote->fecha_emision ? \Carbon\Carbon::parse($lote->fecha_emision)->format('d/m/Y') : '---' }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Responsable</span>
                <span class="value">{{ $lote->responsable }}</span>
            </td>
            <td>
                <span class="label">N° de Carta</span>
                <span class="value">{{ $lote->numero_carta }}</span>
            </td>
            <td colspan="2">
                <span class="label">Asunto</span>
                <span class="value">{{ $lote->asunto }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">2. INFORMACIÓN DEL PROVEEDOR GANADOR</div>
    <table class="info-table">
        <tr>
            <td width="20%">
                <span class="label">RUC</span>
                <span class="value">{{ $lote->ruc ?? '---' }}</span>
            </td>
            <td width="50%">
                <span class="label">Empresa Ganadora</span>
                <span class="value">{{ $lote->empresa_ganadora ?? '---' }}</span>
            </td>
            <td width="30%">
                <span class="label">Centro de Costo</span>
                <span class="value">{{ $lote->centro_costo ?? '---' }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">3. DETALLES COMERCIALES Y FINANCIEROS</div>
    <table class="info-table">
        <tr>
            <td width="25%">
                <span class="label">Moneda</span>
                <span class="value">{{ $lote->moneda }}</span>
            </td>
            <td width="25%">
                <span class="label">Monto + IGV</span>
                <span class="value">{{ $lote->moneda == 'Soles' ? 'S/' : '$' }} {{ number_format($lote->monto_igv, 2) }}</span>
            </td>
            <td width="25%">
                <span class="label">Forma de Pago</span>
                <span class="value">{{ $lote->forma_pago ?? '---' }}</span>
            </td>
            <td width="25%">
                <span class="label">Tipo Solicitud</span>
                <span class="value">{{ $lote->tipo_solicitud }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">N° OC / OS</span>
                <span class="value"><strong>{{ $lote->nro_oc_os }}</strong></span>
            </td>
            <td>
                <span class="label">Fecha OC / OS</span>
                <span class="value">{{ $lote->emision_oc_os ? \Carbon\Carbon::parse($lote->emision_oc_os)->format('d/m/Y') : '---' }}</span>
            </td>
            <td>
                <span class="label">Factura N°</span>
                <span class="value">{{ $lote->factura ?? 'Pendiente' }}</span>
            </td>
            <td>
                <span class="label">F. Vencimiento</span>
                <span class="value">{{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/Y') : '---' }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">4. SEGUIMIENTO DE EJECUCIÓN</div>
    <table class="info-table">
        <tr>
            <td width="25%">
                <span class="label">Conformidad</span>
                <span class="value">{{ $lote->conformidad ?? 'Pendiente' }}</span>
            </td>
            <td width="25%">
                <span class="label">Fecha Entrega</span>
                <span class="value">{{ $lote->fecha_entrega ? \Carbon\Carbon::parse($lote->fecha_entrega)->format('d/m/Y') : '---' }}</span>
            </td>
            <td width="25%">
                <span class="label">Orden Firmada</span>
                <span class="value">{{ $lote->orden_firmada ? 'SÍ' : 'NO' }}</span>
            </td>
            <td width="25%">
                <span class="label">% Ejecución</span>
                <span class="value">{{ $lote->porcentaje_ejecucion ?? 0 }}%</span>
                <div class="progress-container">
                    <div class="progress-bar" style="width: {{ $lote->porcentaje_ejecucion ?? 0 }}%;"></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">OBSERVACIONES</div>
    <table class="info-table">
        <tr>
            <td style="height: 60px;">
                <span class="value">{{ $lote->observacion ?? 'Sin observaciones adicionales.' }}</span>
            </td>
        </tr>
    </table>

    <div class="footer">
        Generado por: <strong>{{ Auth::user()->name }}</strong> | 
        Fecha y Hora: {{ \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s') }} | 
        ID Sistema: {{ $lote->id }}
    </div>

</body>
</html>