<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Backup de Requerimientos</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    th { background-color: #f2f2f2; }
    h3 { text-align: center; margin-bottom: 10px; }
  </style>
</head>
<body>
  <h3>Backup de Requerimientos</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Servicio</th>
        <th>Área</th>
        <th>Solicitante</th>
        <th>Cargo</th>
        <th>Destino</th>
        <th>Sustento</th>
      </tr>
    </thead>
    <tbody>
      @foreach($requerimientos as $req)
      <tr>
        <td>{{ $req->id }}</td>
        <td>{{ $req->fecha }}</td>
        <td>{{ $req->servicio }}</td>
        <td>{{ $req->area_solicitante }}</td>
        <td>{{ $req->nombre_solicitante }}</td>
        <td>{{ $req->cargo_solicitante }}</td>
        <td>{{ $req->destino }}</td>
        <td>{{ $req->sustento }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
