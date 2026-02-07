<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Mantenimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        a.button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Listado de Reportes de Mantenimiento</h2>

    <a class="button" href="{{ route('reportes.create') }}">Nuevo Reporte</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportes as $reporte)
                <tr>
                    <td>{{ $reporte->id }}</td>
                    <td>{{ $reporte->nombre }}</td>
                    <td>{{ $reporte->fecha_inicio }}</td>
                    <td>{{ $reporte->ubicacion }}</td>
                    <td>
                        <a class="button" href="{{ route('reportes.show', $reporte->id) }}">Ver</a>
                        <a class="button" href="{{ route('reportes.edit', $reporte->id) }}">Editar</a>
                        <a class="button" href="{{ route('reportes.pdf', $reporte->id) }}">PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
