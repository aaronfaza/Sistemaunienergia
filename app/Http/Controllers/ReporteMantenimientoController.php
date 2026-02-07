<?php

namespace App\Http\Controllers;

use App\Models\ReporteMantenimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Exports\ReportesMantenimientoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReporteMantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = ReporteMantenimiento::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_inicio', $request->fecha);
        }

        // Total real con filtros
        $totalReportes = (clone $query)->count();

        // Para DataTables: traer TODOS los registros filtrados
        $reportes = $query->orderByDesc('id')->get();

        // Notificaciones aparte
        $notificaciones = ReporteMantenimiento::latest()->take(5)->get();

        return view('dashboard', compact('reportes', 'totalReportes', 'notificaciones'));
    }


    

    public function create()
    {
        return view('reportes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
            'tipo_equipo' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'rotulado' => 'nullable|string|max:255',
            'herramientas' => 'nullable|string',
            'materiales' => 'nullable|string',
            'descripcion_actividad' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'firma_data' => 'required|string', // si quieres obligatoria
        ]);

        // ✅ Guardar foto (si existe)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('reportes_mantenimiento', 'public');
        }

        // ✅ Normalizar herramientas/materiales (vienen como string "a, b, c")
        $herramientas = $request->filled('herramientas')
            ? array_values(array_filter(array_map('trim', explode(',', $request->herramientas))))
            : [];

        $materiales = $request->filled('materiales')
            ? array_values(array_filter(array_map('trim', explode(',', $request->materiales))))
            : [];
        $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('reportes_fotos', 'public');
            }

            $firmaPath = null;
            if ($request->filled('firma_data')) {
                $data = $request->firma_data;

                // data:image/png;base64,xxxx
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $data = base64_decode($data);

                    if ($data === false) {
                        return back()->withErrors(['firma_data' => 'Firma inválida.'])->withInput();
                    }

                    $fileName = 'firma_' . time() . '_' . uniqid() . '.png';
                    $firmaPath = 'firmas/' . $fileName;

                    \Storage::disk('public')->put($firmaPath, $data);
                }
            }

        ReporteMantenimiento::create([
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'tipo_equipo' => $request->tipo_equipo,
            'ubicacion' => $request->ubicacion,
            'rotulado' => $request->rotulado,
            'herramientas' => $herramientas,
            'materiales' => $materiales,
            'descripcion_actividad' => $request->descripcion_actividad,
            'foto' => $fotoPath,
            'firma' => $firmaPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Reporte guardado exitosamente.');
    }

    public function edit(ReporteMantenimiento $reporte)
    {
        return view('reportes.edit', compact('reporte'));
    }

    public function update(Request $request, ReporteMantenimiento $reporte)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after_or_equal:fecha_inicio',
            'tipo_equipo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rotulado' => 'nullable|string|max:255',
            'herramientas' => 'nullable|string',
            'materiales' => 'nullable|string',
            'descripcion_actividad' => 'required|string',
            'firma_data' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // ✅ Normalizar herramientas/materiales (string separado por comas)
        $herramientas = $request->filled('herramientas')
            ? array_values(array_filter(array_map('trim', explode(',', $request->herramientas))))
            : [];

        $materiales = $request->filled('materiales')
            ? array_values(array_filter(array_map('trim', explode(',', $request->materiales))))
            : [];

        // ✅ Si sube nueva foto: borrar anterior + guardar nueva
        if ($request->hasFile('foto')) {
            if ($reporte->foto && Storage::disk('public')->exists($reporte->foto)) {
                Storage::disk('public')->delete($reporte->foto);
            }
            $reporte->foto = $request->file('foto')->store('reportes_mantenimiento', 'public');
        }


        // Foto (opcional)
            if ($request->hasFile('foto')) {
                if (!empty($reporte->foto)) {
                    \Storage::disk('public')->delete($reporte->foto);
                }
                $reporte->foto = $request->file('foto')->store('reportes_fotos', 'public');
            }

            // Firma (opcional)
            if ($request->filled('firma_data')) {
                $data = $request->firma_data;

                if (preg_match('/^data:image\/(\w+);base64,/', $data)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $data = base64_decode($data);

                    if ($data !== false) {
                        if (!empty($reporte->firma)) {
                            \Storage::disk('public')->delete($reporte->firma);
                        }

                        $fileName = 'firma_' . time() . '_' . uniqid() . '.png';
                        $reporte->firma = 'firmas/' . $fileName;
                        \Storage::disk('public')->put($reporte->firma, $data);
                    }
                }
            }
                


        $reporte->update([
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'tipo_equipo' => $request->tipo_equipo,
            'ubicacion' => $request->ubicacion,
            'rotulado' => $request->rotulado,
            'herramientas' => $herramientas,
            'materiales' => $materiales,
            'descripcion_actividad' => $request->descripcion_actividad,
            // ⚠️ foto NO va aquí porque se maneja arriba (solo si suben nueva)
        ]);

        // por si se cambió foto arriba, asegurar persistencia
        $reporte->save();

        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado correctamente.');
    }

    public function pdf($id)
    {
        $reporte = ReporteMantenimiento::findOrFail($id);
        $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
        return $pdf->download('reporte_mantenimiento_' . $id . '.pdf');
    }

    public function show($id)
    {
        $reporte = ReporteMantenimiento::findOrFail($id);
        $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
        return $pdf->stream("reporte_{$reporte->id}.pdf");
    }

    public function destroy(ReporteMantenimiento $reporte)
    {
        // ✅ borrar foto del storage al eliminar
        if ($reporte->foto && Storage::disk('public')->exists($reporte->foto)) {
            Storage::disk('public')->delete($reporte->foto);
        }

        $reporte->delete();
        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado correctamente.');
    }

    public function generarPdf(ReporteMantenimiento $reporte)
    {
        $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));
        return $pdf->download('reporte_mantenimiento_' . $reporte->id . '.pdf');
    }


public function backupExcel()
{
    $empresa = 'UNIENERGÍA ABC S.A.C.';
    $generadoPor = Auth::user()->name ?? 'Usuario';
    $generadoEn = Carbon::now()->format('d/m/Y H:i');

    $filename = 'Backup_Reportes_Mantenimiento_' . Carbon::now()->format('Ymd_His') . '.xlsx';

    return Excel::download(
        new ReportesMantenimientoExport($empresa, $generadoPor, $generadoEn),
        $filename
    );
}


}
