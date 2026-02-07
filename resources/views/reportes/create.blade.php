
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Reporte</title>
</head>
<body>
    <h1>Agregar Reporte de Mantenimiento</h1>

    <form action="{{ route('reportes.store') }}" method="POST">
        @csrf
        <label>Nombre:</label><br>
        <input type="text" name="nombre"><br><br>

        <label>Fecha de Inicio:</label><br>
        <input type="date" name="fecha_inicio"><br><br>

        <label>Fecha de Fin:</label><br>
        <input type="date" name="fecha_fin"><br><br>

        <label>Ubicación:</label><br>
        <input type="text" name="ubicacion"><br><br>

        <label>Actividad:</label><br>
        <textarea name="descripcion_actividad" rows="4" cols="50"></textarea><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
