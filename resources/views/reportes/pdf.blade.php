<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Mantenimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .logo {
            width: 150px;
        }
        .header {
            text-align: center;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 10px;
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
        .signature {
            height: 80px;
            border: 1px solid #000;
            margin-top: 30px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .left-info {
            text-align: left;
            font-size: 12px;
        }

        .left-info .bold-title {
            font-weight: bold;
            font-size: 14px;
        }

        .right-logo {
            text-align: right;
            font-size: 12px;
        }

        .logo {
            width: 100px;
            display: block;
            margin-left: auto;
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

        /* ===== FOTO EN PDF ===== */
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
            height: 260px;              /* altura fija para que el formato no “salte” */
            text-align: center;
            vertical-align: middle;
        }
        .photo-box img{
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;        /* para que no se deforme */
        }
        .photo-empty{
            font-size: 11px;
            color: #444;
            padding: 14px 8px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header-container" style="margin-bottom: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <!-- Lado izquierdo: textos -->
        <div style="font-size: 12px;">
            <div style="font-weight: bold; font-size: 14px;">Plan Anual de Mantenimiento 2026</div>
            <div>Mantenimiento Motores, Unidades de Bombeo y Bombas de Transferencia</div>
            <div>Área de Mecánica</div>
        </div>

        <!-- Lado derecho: logo -->
        <div style="display: flex; align-items: center; text-align: right;">
            <img src="{{ public_path('img/logo1.png') }}" alt="Logo Empresa" style="height: 40px; margin-top: -50px;">
        </div>
        </div>
    </div>

    <!-- Título centrado -->
    <div class="title" style="font-size: 24px; text-align: center; margin-top: 30px; margin-bottom: 35px;">
        Reporte de Mantenimiento
    </div>

    <div class="section-title">Datos Generales</div>
    <table>
        <tr>
            <td><strong>Nombre:</strong> {{ $reporte->nombre }}</td>
            <td><strong>Fecha de Inicio:</strong> {{ $reporte->fecha_inicio }}</td>
            <td><strong>Fecha de Término:</strong> {{ $reporte->fecha_termino }}</td>
        </tr>

        <tr>
            <td colspan="3" style="padding-top: -80px; padding-buttom: 34px;">
                <table style="width: 100%; border: none;">
                    <tr style="border: none;">
                        <td style="border: none; vertical-align: top;"><strong>Tipo de Equipo:</strong></td>
                        <td style="border: none;">
                            <label style="display: inline-flex; align-items: baseline; margin-right: 5px; font-size: 11px; line-height: 1;">
                                <input type="checkbox" style="margin: 0 6px 0 0; position: relative; top: 3px; transform: scale(1); left: 5px;" {{ $reporte->tipo_equipo === 'Motor' ? 'checked' : '' }}>
                                Motor
                            </label>
                            <label style="display: inline-flex; align-items: baseline; margin-right: 5px; font-size: 11px; line-height: 1;">
                                <input type="checkbox" style="margin: 0 6px 0 0; position: relative; top: 3px; transform: scale(1); left: 5px;" {{ $reporte->tipo_equipo === 'Unidad de Bombeo Mecánico' ? 'checked' : '' }}>
                                Unidad de Bombeo Mecánico
                            </label>
                            <label style="display: inline-flex; align-items: center; margin-right: 25px;">
                                <input type="checkbox" style="margin: 0 6px 0 0; position: relative; top: 3px; transform: scale(1); left: 5px;" {{ $reporte->tipo_equipo === 'Bomba de Transferencia' ? 'checked' : '' }}>
                                Bomba de Transferencia
                            </label>
                            <label style="display: inline-flex; align-items: center; margin-right: 25px;">
                                <input type="checkbox" style="margin: 0 6px 0 0; position: relative; top: 3px; transform: scale(1); left: 5px;" {{ $reporte->tipo_equipo === 'Caja Reductora' ? 'checked' : '' }}>
                                Caja Reductora
                            </label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="width: 50%;"><strong>Ubicación:</strong> {{ $reporte->ubicacion }}</td>
            <td colspan="2"><strong>Rotulado / Marca / Serie:</strong> {{ $reporte->rotulado }}</td>
        </tr>
    </table>

    <div class="section-title"><strong style="font-size: 0.8rem;"> {{ $reporte->titulo }} </strong></div>
    <table>
        <tr>
            <th class="section-title" style="width: 50%;">Herramientas</th>
            <th class="section-title" style="width: 50%;">Materiales / Insumos</th>
        </tr>
        @php
            $max = max(count($reporte->herramientas ?? []), count($reporte->materiales ?? []));
        @endphp
        @for ($i = 0; $i < $max; $i++)
            <tr>
                <td>{{ $reporte->herramientas[$i] ?? '' }}</td>
                <td>{{ $reporte->materiales[$i] ?? '' }}</td>
            </tr>
        @endfor
    </table>

    <div class="section-title">Descripción de la actividad</div>
    <table>
        @foreach(explode(',', $reporte->descripcion_actividad) as $linea)
            <tr>
                <td style="height: 20px;">
                    {{ trim($linea) }}
                </td>
            </tr>
        @endforeach
    </table>

    <!-- ✅ FOTO DE EVIDENCIA (debajo de descripción) -->
    <div class="photo-title">Evidencia fotográfica</div>
    <div class="photo-wrap">
        <table style="width:100%; border-collapse:collapse; margin:0;">
            <tr>
                <td class="photo-box" style="border:1px solid #000;">
                    @if(!empty($reporte->foto) && file_exists(public_path('storage/'.$reporte->foto)))
                        <img src="{{ public_path('storage/'.$reporte->foto) }}" alt="Foto del reporte">
                    @elseif(!empty($reporte->foto) && file_exists(public_path($reporte->foto)))
                        {{-- Por si guardaste ruta directa en public --}}
                        <img src="{{ public_path($reporte->foto) }}" alt="Foto del reporte">
                    @else
                        <div class="photo-empty">
                            No se adjuntó evidencia fotográfica para este reporte.
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="no-border" style="margin-top: 60px; width: 100%;">
        <tr>
            <td style="text-align: left; border: none;">
                @if(!empty($reporte->firma) && file_exists(public_path('storage/'.$reporte->firma)))
                <div >
                    
                    <img src="{{ public_path('storage/'.$reporte->firma) }}" alt="Firma" style="height:90px; max-width:280px; align-items: center">
                    <div style="margin-top: 2px; font-weight: bold;">
                    {{ $reporte->nombre }}
                    </div>
                    <div style="font-size: 10px; color: #333;">
                        Personal Responsable de Mantenimiento
                    </div>
                    <div style="margin-top: 4px;">
                    <img
                    src="{{ public_path('img/logo1.png') }}"
                    alt="Logo Unienergia ABC"
                    style="height: 20px; vertical-align: middle;"
                    >
                    <span style="font-size: 10px; color: #555; vertical-align: middle;">
                    </span>
                    <!-- FECHA DIGITAL -->
                    <div style="margin-top: 3px; font-size: 9.5px; color: #666;">
                        Firmado digitalmente el
                        {{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}
                    </div>
                </div>
                </div>
                @endif
            </td>

            <td style="text-align: right; border: none;">
                <div>
                    <div style="border-bottom: 1px solid #000; width: 180px; height: 30px; display: inline-block;"></div>
                    <div style="margin-top: 5px;">Firma del Supervisor Responsable</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
