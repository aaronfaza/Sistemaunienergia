<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formato de Requerimiento</title>


  <style>
  /* Solo cambio de fuente (sin modificar tamaños) */
  .sign-table,
  .sign-table thead th,
  .sign-table td,
  .sign-table .name,
  .sign-table .role {
    font-family: "DejaVu Sans", Arial, Helvetica, sans-serif !important;
  }
</style>

<style>
  .sign-table { font-family: "DejaVu Sans", Arial, Helvetica, sans-serif !important; }
  .sign-table thead th { font-family: "DejaVu Serif", Georgia, "Times New Roman", serif !important; }
  .sign-table .name, .sign-table .role { font-family: "DejaVu Sans", Arial, Helvetica, sans-serif !important; }
</style>

  <style>
    @page { margin: 10mm 12mm; }
    body { font-family: Arial, sans-serif; font-size: 9.8px; margin: 0; }

    /* Encabezado compacto */
    .header { width: 100%; border: 1px solid #000; border-collapse: collapse; margin-bottom: 4px; }
    .header td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; }
    .header .logo { width: 24%; text-align: center; }
    .header .title { width: 48%; text-align: center; font-size: 11px; font-weight: bold; color: #002b5c; line-height: 1.2; }
    .header .meta { width: 28%; font-size: 9px; }

    /* Bandas/Secciones */
    .subtitle{
      background:#d9e2f3; text-align:center; font-weight:bold;
      padding:3px; border:1px solid #000; margin:6px 0 4px; font-size:10px;
    }

    /* Información general (con aire) */
    .info-table{ width:100%; border-collapse:collapse; margin-bottom:2px; }
    .info-table td{ padding:4px 3px; vertical-align:top; }
    .info-label{ font-weight:bold; width:170px; }
    .info-destino{ vertical-align:top; padding-left:24px; }
    .info-destino div{ margin-bottom:5px; }

    /* Tabla de ítems tipo planilla */
    .items{ width:100%; border-collapse:collapse; font-size:9.3px; }
    .items th,.items td{ border:1px solid #000; text-align:center; }
    .items th{ background:#d9e2f3; font-weight:bold; padding:3px 2px; }
    .items td{ padding:2px 3px; }
    .items td.desc{ text-align:left; }

    /* Leyenda bajo la grilla */
    .legend{ font-size:9px; margin-top:3px; }

    /* Sustento pequeño */
    .band-blue{
      background:#d9e2f3; color:#000; font-weight:bold; text-align:center;
      padding:3px; border:1px solid #000; margin:8px 0 3px; font-size:10px;
    }
    .sustento-box{ border:1px solid #000; padding:5px 8px; font-size:9.5px; }
    .sustento-lines .line{ border-bottom:1px solid #000; height:14px; margin-top:4px; }

    /* Firmas (sin logos) */
    .sign-table{ width:100%; border-collapse:collapse; page-break-inside: avoid; }
    .sign-table th,.sign-table td{ border:1px solid #000; }
    .sign-table th{ background:#fff; font-weight:800; text-align:center; padding:5px; font-size:11px; }
    .sign-table .box{ height:95px; padding:8px; vertical-align:bottom; text-align:center; }
    .sign-table .name{ font-weight:800; font-size:11px; padding-top:6px; }
    .sign-table .role{ font-size:11px; padding-bottom:6px; }

    .foot-rule{ border-top:1px solid #000; margin:8px 0 5px; }
    .foot-note{ font-size:8.3px; text-align:center; }
  </style>

<style>
  /* Lista destino: columnas alineadas */
  .destino-table{
    width:auto;
    border-collapse:collapse;
    margin-top:4px;
    font-size:11px;
  }
  .destino-table td{ border:none; padding:2px 0; }
  .destino-table .check-cell{
    width:14px;
    padding-right:9px;
    vertical-align:middle;
  }
  .destino-table .text-cell{
    vertical-align:top;     /* ⬅️ anclar arriba */
    padding-top:8px;      /* ⬅️ baja el texto (ajusta 2–4px a gusto) */
    line-height:1.15;
    white-space:nowrap;
  }
  .destino-table input[type="checkbox"]{
    width:11px; height:11px;
    margin:0;
    position:relative; top:0;
    transform:scale(1);
  }
  .destino-title{ font-weight:bold; margin-bottom:2px; }
</style>

<style>
  /* Firma sin líneas pero con el mismo espacio reservado */
  .sign-table .box{
    text-align:center;
    padding:12px 10px;
  }
  .sign-placeholder{
    height:28px;           /* ⇦ ajusta a 24–32px si quieres más/menos espacio */
  }
  .sign-table .name{ font-weight:600; margin-top:2px; }
  .sign-table .role{ font-size:10px; }
</style>



</head>
<body>

  <!-- ENCABEZADO -->
  <table class="header">
    <tr>
      <td class="logo">
        <img src="{{ public_path('img/logo1.png') }}" alt="Logo" style="max-height:28px;">
      </td>
      <td class="title">
        FORMATO DE REQUERIMIENTO<br>
        PARA MATERIALES Y/O SERVICIOS
      </td>
      <td class="meta">
        CÓDIGO: {{ $req->codigo ?? 'REQ-2024' }}<br>
        VERSIÓN: 01<br>
        FECHA: {{ \Carbon\Carbon::parse($req->fecha)->format('d/m/Y') }}
      </td>
    </tr>
  </table>
<div style="margin:10px;"></div>

  <div class="subtitle">INFORMACIÓN GENERAL</div>
  <div style="margin:10px;"></div>
  <table class="info-table">
    <tr>
      <td class="info-label">Fecha de requerimiento:</td>
      <td>{{ \Carbon\Carbon::parse($req->fecha)
      ->locale('es')
      ->isoFormat('dddd, DD [de] MMMM [de] YYYY') }}</td>
      @php
  // Acepta array o string "Lote IX, Oficina"
  $destSel = is_array($req->destino)
      ? array_map('trim', $req->destino)
      : array_filter(array_map('trim', explode(',', (string)$req->destino)));

  $opDestinos = ['Lote IX','Oficina','Unidad vehicular','Vivienda'];
@endphp

<td class="info-destino" rowspan="5">
  <div class="destino-title">Destino</div>
  <table class="destino-table">
    @foreach($opDestinos as $opt)
      <tr>
        <td class="check-cell">
          <input type="checkbox" {{ in_array($opt, $destSel) ? 'checked' : '' }}>
        </td>
        <td class="text-cell">
          {{ $opt }}@if(in_array($opt, ['Lote IX','Unidad vehicular','Vivienda']))*@endif
        </td>
      </tr>
    @endforeach
  </table>
</td>
    </tr>
    <tr>
      <td class="info-label">Requerimiento de:</td>
      <td>{{ $req->servicio }}</td>
    </tr>
    <tr>
      <td class="info-label">Área solicitante:</td>
      <td>{{ $req->area_solicitante }}</td>
    </tr>
    <tr>
      <td class="info-label">Nombre del solicitante:</td>
      <td>{{ $req->nombre_solicitante }}</td>
    </tr>
    <tr>
      <td class="info-label">Cargo del solicitante:</td>
      <td>{{ $req->cargo_solicitante }}</td>
    </tr>
  </table>
  <p style="font-size:8.6px; text-align:right; margin:0;">*Especificar en la descripción del formato</p>
  <div class="foot-rule" style="margin: 20px;"></div>

  <!-- GRILLA DE DETALLE (muchas filas finas) -->
  <table class="items">
    <thead>
      <tr>
        <th style="width:5%;">N°</th>
        <th style="width:60%;">DESCRIPCIÓN</th>
        <th style="width:15%;">IDEN.</th>
        <th style="width:8%;">CANT.</th>
        <th style="width:12%;">UNID.</th>
      </tr>
    </thead>
    <tbody>
      @foreach($req->detalles as $i => $det)
      <tr>
        <td>{{ $i+1 }}</td>
        <td class="desc">{{ $det->descripcion }}</td>
        <td>{{ $det->identificacion }}</td>
        <td>{{ $det->cantidad }}</td>
        <td>{{ $det->unidad }}</td>
      </tr>
      @endforeach

      {{-- Relleno para igualar el formato (ajusta el número) --}}
      @php
        $rowsTarget = 24;  // ← MISMO "alto" que tu ejemplo
        $rowsToAdd  = max(0, $rowsTarget - count($req->detalles));
      @endphp
      @for ($r = 0; $r < $rowsToAdd; $r++)
      <tr>
        <td>&nbsp;</td><td class="desc"></td><td></td><td></td><td></td>
      </tr>
      @endfor
    </tbody>
  </table>

  <div class="legend"><b>IDEN.:</b> Identificación &nbsp;&nbsp; <b>CANT.:</b> Cantidad &nbsp;&nbsp; <b>UNID.:</b> Unidad</div>

  <!-- SUSTENTO (pequeño) -->
  <div class="band-blue">SUSTENTO</div>
  <div class="sustento-box">
    {{ mb_strtoupper($req->sustento ?? '', 'UTF-8') }}
  </div>
<div style="margin:25px;"></div>
  <!-- FIRMAS (sin logos) -->
  <div class="band-blue">FIRMAS</div>
  <table class="sign-table">
    <thead>
      <tr>
        <th>SOLICITANTE</th>
        <th>APROBADO POR:</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td class="box">
        <div class="sign-placeholder"></div>
        <div class="destino-title">{{ $req->nombre_solicitante }}</div>
        <div class="role">{{ $req->cargo_solicitante }}</div>
      </td>
      <td class="box">
        <div class="sign-placeholder"></div>
        <div class="destino-title">{{ $req->aprobador_nombre ?? 'Juan Ticlla Enciso' }}</div>
        <div class="role">{{ $req->aprobador_cargo ?? 'Jefe de Operaciones del Lote IX' }}</div>
      </td>
    </tr>

    </tbody>
  </table>

  <div class="foot-rule"></div>
  <div class="foot-note">
    Este documento es propiedad de Unienergía ABC. Prohibida su reproducción total o parcial sin autorización.
  </div>

</body>
</html>
