<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Anomalía</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 35px;
        }
        .section-title {
            background-color: #ddd;
            padding: 5px;
            font-weight: bold;
            margin-top: 15px;
            text-transform: uppercase;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        td, th {
            border: 1px solid #000;
            padding: 4px;
        }
        .no-border {
            border: none;
        }
        input[type="checkbox"] {
            vertical-align: middle;
            position: relative;
            top: -1px;
            margin-right: 6px;
            transform: scale(1);
        }
        label {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            font-size: 11px;
        }
        .gravedad-tag{
            display: inline-block;
            padding: 3px 10px;
            font-weight: bold;
            border: 1px solid #000;
        }
        .photo-wrap{
            border: 1px solid #000;
            padding: 6px;
            margin-top: 6px;
        }
        .photo-title{
            font-weight: bold;
            margin: 0 0 6px 0;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            background: #eee;
            padding: 4px;
            border: 1px solid #000;
        }
        .photo-box{
            width: 100%;
            height: 260px;
            text-align: center;
            vertical-align: middle;
        }
        .photo-box img{
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;
        }
        .photo-empty{
            font-size: 11px;
            color: #444;
            padding: 14px 8px;
            text-align: center;
        }
        .footer-registro {
            margin-top: 50px;
            border-top: 1px solid #000;
            padding-top: 6px;
            font-size: 9.5px;
            color: #444;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div style="font-size: 12px;">
            <div style="font-weight: bold; font-size: 14px;">Plan Anual de Mantenimiento 2026</div>
            <div>Mantenimiento Motores, Unidades de Bombeo y Bombas de Transferencia</div>
            <div>Área de Mecánica</div>
        </div>
        <div style="display: flex; align-items: center; text-align: right;">
            <img src="{{ public_path('img/Logo1.png') }}" alt="Logo Empresa" style="height: 40px; margin-top: -50px;">
        </div>
    </div>

    <div class="title">Reporte de Anomalía</div>

    <div class="section-title">Datos Generales</div>
    <table>
        <tr>
            <td><strong>Reportado por:</strong> {{ $anomalia->nombre }}</td>
            <td><strong>Fecha del reporte:</strong> {{ $anomalia->created_at->format('d/m/Y H:i') }}</td>
            <td><strong>Estado:</strong> {{ $anomalia->estado }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <table style="width: 100%; border: none;">
                    <tr style="border: none;">
                        <td style="border: none; vertical-align: top;"><strong>Tipo de Equipo:</strong></td>
                        <td style="border: none;">
                            <label><input type="checkbox" {{ $anomalia->tipo_equipo === 'Motor' ? 'checked' : '' }}> Motor</label>
                            <label><input type="checkbox" {{ $anomalia->tipo_equipo === 'Unidad de Bombeo Mecánico' ? 'checked' : '' }}> Unidad de Bombeo Mecánico</label>
                            <label><input type="checkbox" {{ $anomalia->tipo_equipo === 'Bomba de Transferencia' ? 'checked' : '' }}> Bomba de Transferencia</label>
                            <label><input type="checkbox" {{ $anomalia->tipo_equipo === 'Caja Reductora' ? 'checked' : '' }}> Caja Reductora</label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 50%;"><strong>Pozo / Ubicación:</strong> {{ $anomalia->pozo }}</td>
            <td colspan="2">
                <strong>Gravedad:</strong>
                <span class="gravedad-tag">{{ $anomalia->gravedad }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Descripción de la anomalía</div>
    <table>
        <tr>
            <td style="height: 60px; vertical-align: top;">
                {{ $anomalia->descripcion }}
            </td>
        </tr>
    </table>

    <!-- EVIDENCIA FOTOGRÁFICA -->
    <div class="photo-title">Evidencia fotográfica</div>
    <div class="photo-wrap">
        <table style="width:100%; border-collapse:collapse; margin:0;">
            <tr>
                <td class="photo-box" style="border:1px solid #000;">
                    @if(!empty($anomalia->foto) && file_exists(public_path('storage/'.$anomalia->foto)))
                        <img src="{{ public_path('storage/'.$anomalia->foto) }}" alt="Foto de la anomalía">
                    @else
                        <div class="photo-empty">
                            No se adjuntó evidencia fotográfica para esta anomalía.
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- PIE DE PÁGINA: FECHA DE REGISTRO POR SISTEMA -->
    <div class="footer-registro">
        Anomalía registrada en el sistema el {{ $anomalia->created_at->format('d/m/Y H:i') }}
        &nbsp;·&nbsp;
        Documento generado el {{ now()->format('d/m/Y H:i') }}
        &nbsp;·&nbsp;
        Sistema UniEnergía ABC
    </div>

</body>
</html>
