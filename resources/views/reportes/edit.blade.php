<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reporte</title>
</head>
<body>
    <h1>Editar Reporte</h1>

    <form action="{{ route('reportes.update', $reporte->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="{{ $reporte->nombre }}"><br><br>

        <label>Fecha de Inicio:</label><br>
        <input type="date" name="fecha_inicio" value="{{ $reporte->fecha_inicio }}"><br><br>

        <label>Fecha de Fin:</label><br>
        <input type="date" name="fecha_fin" value="{{ $reporte->fecha_fin }}"><br><br>

        <label>Ubicación:</label><br>
        <input type="text" name="ubicacion" value="{{ $reporte->ubicacion }}"><br><br>

        <label>Actividad:</label><br>
        <textarea name="descripcion_actividad" rows="4" cols="50">{{ $reporte->descripcion_actividad }}</textarea><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
