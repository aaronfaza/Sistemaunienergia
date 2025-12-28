<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carta SO-PRO {{ $carta->codigo }}</title>

<style>
  body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #1e293b;
    margin: 20px;
  }

  /* ===== HEADER ===== */
  .header-table {
    width: 100%;
    border-bottom: 2px solid #003366;
    padding-bottom: 8px;
    margin-bottom: 12px;
  }

  .logo {
    width: 110px;
  }

  .empresa-info {
    font-size: 9px;
    color: #6b7280;
    opacity: 0.85;
    line-height: 1.4;
  }

  .titulo {
    text-align: right;
  }

  .titulo h1 {
    font-size: 16px;
    margin: 0;
    color: #003366;
  }

  .titulo span {
    font-size: 10px;
    color: #475569;
  }

  /* ===== SECCIONES ===== */
  .section {
    margin-bottom: 14px;
  }

  .section h4 {
    font-size: 12px;
    margin-bottom: 6px;
    color: #003366;
    border-bottom: 1px solid #ddd;
    padding-bottom: 3px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  td {
    padding: 6px;
    vertical-align: top;
  }

  .label {
    font-weight: bold;
    width: 22%;
    color: #1f2937;
  }

  /* ===== FOOTER ===== */
  .footer {
    position: fixed;
    bottom: 25px;
    left: 20px;
    right: 20px;
    font-size: 9px;
    color: #6b7280;
  }

  .footer-line {
    border-top: 1px solid #7a1f1f; /* rojo granate */
    margin-bottom: 6px;
  }
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<table width="100%" style="border-bottom:2px solid #003366; padding-bottom:8px; margin-bottom:14px;">
  <tr>
    <!-- COLUMNA IZQUIERDA: LOGO + CÓDIGO -->
    <td width="55%" valign="top">
      <img src="{{ public_path('img/logo1.png') }}" style="width:230px;">

      <div style="margin-top:10px; font-size:14px; font-weight:bold; letter-spacing:0.5px;">
        {{ $carta->codigo }}
      </div>
    </td>

   <!-- COLUMNA DERECHA: DATOS EMPRESA -->
<td width="25%" valign="top" align="right" style="padding:0;">
  <div style="
      font-size:10.5px;
      color:#8a8a8a;
      line-height:1.2;
      margin:0;
      padding:0;
  ">
    <div style="margin:0; padding:0;">
      Empresa de Recursos Energéticos
    </div>
    <div style="margin:0; padding:0; font-weight:bold; color:#7a7a7a;">
      UNIENERGÍA ABC S.A.C.
    </div>
    <div style="margin:0; padding:0;">
      Av. Canaval Moreyra N° 425, Ofic. 31 – San Isidro
    </div>
    <div style="margin:0; padding:0;">
      Lima – Perú
    </div>
    <div style="margin:0; padding:0;">
      Telf.: (51-1) 442-2277
    </div>
    <div style="margin:0; padding:0;">
      Fax : (51-1) 222-5726
    </div>
  </div>
</td>

  </tr>
</table>


<!-- ================= DATOS GENERALES ================= -->
<div class="section">
  <h4>Datos Generales</h4>
  <table>
    <tr>
      <td class="label">Mes</td><td>{{ $carta->mes }}</td>
      <td class="label">Área</td><td>{{ $carta->area }}</td>
    </tr>
    <tr>
      <td class="label">Autorizado por</td><td>{{ $carta->autorizado_por }}</td>
      <td class="label">N° Orden</td><td>{{ $carta->nro_orden }}</td>
    </tr>
  </table>
</div>

<!-- ================= SERVICIO ================= -->
<div class="section">
  <h4>Servicio / Compra</h4>
  <p><strong>{{ $carta->servicio_compra }}</strong></p>
  <p>{{ $carta->descripcion }}</p>
</div>

<!-- ================= PROVEEDOR Y MONTOS ================= -->
<div class="section">
  <h4>Proveedor y Montos</h4>
  <table>
    <tr>
      <td class="label">Proveedor</td>
      <td colspan="3">{{ $carta->proveedor_elegido }}</td>
    </tr>
    <tr>
      <td class="label">Monto (S/)</td>
      <td>S/ {{ number_format($carta->monto_soles, 2) }}</td>
      <td class="label">Monto ($)</td>
      <td>$ {{ number_format($carta->monto_dolares, 2) }}</td>
    </tr>
  </table>
</div>

<!-- ================= FECHAS ================= -->
<div class="section">
  <h4>Control de Fechas</h4>
  <table>
    <tr>
      <td class="label">Recepción</td><td>{{ $carta->fecha_recepcion ?? '—' }}</td>
      <td class="label">Vencimiento</td><td>{{ $carta->fecha_vencimiento ?? '—' }}</td>
      <td class="label">Pago</td><td>{{ $carta->fecha_pago ?? '—' }}</td>
    </tr>
  </table>
</div>

<!-- ================= FOOTER ================= -->
<div class="footer">
  <div class="footer-line"></div>
  <div>
    Oficina Operaciones : Calle Tarapacá N° 381, Urb. Barrio Particular,
    Talara – Piura / Telf. (51-73) 382402 Fax (51-73) 383141<br>
    Oficina Servicios Petroleros : Zona Industrial Mz. B Lote 01 – Talara Alta,
    Talara – Piura / Telefax: (51-73) 693161
  </div>
</div>


<hr style="border:none; border-top:1px solid #7a1f1f; margin:12px 0 6px 0;">

<div style="
    font-size:9px;
    color:#8a8a8a;
    text-align:right;
    margin:0;
    padding:0;
    line-height:1.2;
">
  Generado por: <strong>{{ Auth::user()->name }}</strong> —
  {{ now()->format('d/m/Y H:i') }}
</div>


</body>
</html>
