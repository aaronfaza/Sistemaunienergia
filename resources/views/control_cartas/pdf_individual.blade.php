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
  }
  .header {
    border-bottom: 2px solid #003366;
    margin-bottom: 15px;
    padding-bottom: 8px;
  }
  .title {
    font-size: 16px;
    font-weight: bold;
    color: #003366;
  }
  .section {
    margin-bottom: 12px;
  }
  .section h4 {
    font-size: 12px;
    margin-bottom: 6px;
    color: #003366;
    border-bottom: 1px solid #ddd;
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
    width: 30%;
  }
</style>
</head>
<body>

<div class="header">
  <div class="title">Carta SO-PRO — {{ $carta->codigo }}</div>
  <div>Fecha: {{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}</div>
</div>

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

<div class="section">
  <h4>Servicio / Compra</h4>
  <p><strong>{{ $carta->servicio_compra }}</strong></p>
  <p>{{ $carta->descripcion }}</p>
</div>

<div class="section">
  <h4>Proveedor y Montos</h4>
  <table>
    <tr>
      <td class="label">Proveedor</td><td>{{ $carta->proveedor_elegido }}</td>
    </tr>
    <tr>
      <td class="label">Monto (S/)</td><td>S/ {{ number_format($carta->monto_soles, 2) }}</td>
      <td class="label">Monto ($)</td><td>$ {{ number_format($carta->monto_dolares, 2) }}</td>
    </tr>
  </table>
</div>

<div class="section">
  <h4>Fechas</h4>
  <table>
    <tr>
      <td class="label">Recepción</td><td>{{ $carta->fecha_recepcion }}</td>
      <td class="label">Vencimiento</td><td>{{ $carta->fecha_vencimiento }}</td>
      <td class="label">Pago</td><td>{{ $carta->fecha_pago }}</td>
    </tr>
  </table>
</div>

</body>
</html>
