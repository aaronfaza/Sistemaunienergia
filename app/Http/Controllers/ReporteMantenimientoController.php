<?php


namespace App\Http\Controllers;


use App\Models\ReporteMantenimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteMantenimientoController extends Controller
{
    // Mostrar todos los reportes
   public function index(Request $request)
{
    $query = ReporteMantenimiento::query();

    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    if ($request->filled('fecha')) {
        $query->whereDate('fecha_inicio', $request->fecha);
    }

    $reportes = $query->orderByDesc('id')->get();

    return view('dashboard', compact('reportes'));
}

    // Formulario de creación
    public function create()
    {
        return view('reportes.create');
    }

    // Guardar nuevo reporte
    public function store(Request $request)
    {
        $request->validate([
        'nombre' => 'required',
        'fecha_inicio' => 'required|date',
        'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
        'tipo_equipo' => 'nullable|string',
        'ubicacion' => 'nullable|string',
        'rotulado' => 'nullable|string',
        'herramientas' => 'nullable|string',
        'materiales' => 'nullable|string',
        'descripcion_actividad' => 'nullable|string',
    ]);

        ReporteMantenimiento::create([
        'nombre' => $request->nombre,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_termino' => $request->fecha_termino,
        'tipo_equipo' => $request->tipo_equipo,
        'ubicacion' => $request->ubicacion,
        'rotulado' => $request->rotulado,
        'herramientas' => explode(',', $request->herramientas), // 👈 convertir a array
        'materiales' => explode(',', $request->materiales),     // 👈 convertir a array
        'descripcion_actividad' => $request->descripcion_actividad,
    ]);

    return redirect()->route('dashboard')->with('success', 'Reporte guardado exitosamente.');
    }

    // Formulario de edición
    public function edit(ReporteMantenimiento $reporte)
    {
        return view('reportes.edit', compact('reporte'));
    }

    // Actualizar un reporte existente
    public function update(Request $request, ReporteMantenimiento $reporte)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
            'tipo_equipo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rotulado' => 'nullable|string|max:255',
            'herramientas' => 'nullable|array',
            'materiales' => 'nullable|array',
            'descripcion_actividad' => 'required|string',
        ]);

        $reporte->update([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'tipo_equipo' => $request->tipo_equipo,
            'ubicacion' => $request->ubicacion,
            'rotulado' => $request->rotulado,
            'herramientas' => $request->herramientas,
            'materiales' => $request->materiales,
            'descripcion_actividad' => $request->descripcion_actividad,
        ]);

        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado correctamente.');
    }

    public function pdf($id)
{
    $reporte = ReporteMantenimiento::findOrFail($id);
    $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
    return $pdf->download('reporte_mantenimiento_'.$id.'.pdf');
}

 
    public function show($id)
{
    $reporte = ReporteMantenimiento::findOrFail($id);
    
    // Si deseas mostrar una vista HTML:
    // return view('reportes.show', compact('reporte'));

    // Si deseas descargar como PDF directamente:
    $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
    return $pdf->stream("reporte_{$reporte->id}.pdf"); // o ->download(...) si deseas descarga directa
}



    // Eliminar un reporte
    public function destroy(ReporteMantenimiento $reporte)
    {
        $reporte->delete();
        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado correctamente.');
    }

    // Generar PDF
    public function generarPdf(ReporteMantenimiento $reporte)
    {
        $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
        return $pdf->download('reporte_mantenimiento_'.$reporte->id.'.pdf');
    }
    

    
}
