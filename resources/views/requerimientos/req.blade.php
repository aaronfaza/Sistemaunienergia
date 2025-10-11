<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Requerimientos</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h2>Listado de Requerimientos</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($requerimientos as $req)
        <tr>
          <td>{{ $req->id }}</td>
          <td>{{ $req->descripcion }}</td>
          <td>{{ $req->estado }}</td>
          <td>{{ $req->created_at->format('d/m/Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
