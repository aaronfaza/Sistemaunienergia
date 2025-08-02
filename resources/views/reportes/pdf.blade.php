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
            text-align: center; /* <--- centrado agregado */
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
            width: 100px; /* tamaño reducido del logo */
            display: block;
            margin-left: auto;
        }

        input[type="checkbox"] {
            vertical-align: middle;
            position: relative;
            top: -1px; /* Ajustable si usas wkhtmltopdf o domPDF */
            margin-right: 6px;
            transform: scale(1); /* Puedes usar 1.1 si quieres más grande */
        }

        label {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            font-size: 11px;
        }
        

    </style>
</head>
<body>

    <div class="header-container" style="margin-bottom: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <!-- Lado izquierdo: textos -->
        <div style="font-size: 12px;">
            <div style="font-weight: bold; font-size: 14px;">Plan Anual de Mantenimiento 2025</div>
            <div>Mantenimiento Motores, Unidades de Bombeo y Bombas de Transferencia</div>
            <div>Área de Mecánica</div>
        </div>

        <!-- Lado derecho: logo + texto alineado a la derecha -->
        <div style="display: flex; align-items: center; text-align: right;">
            <img src="{{ public_path('img/logo.png.png') }}" alt="Logo Empresa" style="height: 40px; margin-top: -50px;">
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

    <div class="section-title">Herramientas y Materiales/Insumos</div>
    <table>
        <tr>
            <th class="section-title" style="width: 50%;">Herramientas</th>
            <th  class="section-title" style="width: 50%;">Materiales / Insumos</th>
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

   <table class="no-border" style="margin-top: 160px; width: 100%;">
    <tr>
        <!-- Firma del Supervisor Responsable (izquierda) -->
        <td style="text-align: left; border: none;">
            <div>
                <div style="border-bottom: 1px solid #000; width: 180px; height: 30px; display: inline-block;"></div>
                <div style="margin-top: 5px;">Firma del Personal Responsable</div>
            </div>
        </td>

        <!-- Firma del Personal Responsable (derecha) -->
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
