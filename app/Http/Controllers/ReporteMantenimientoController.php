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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
            'firma_data' => 'required|string', // si quieres obligatoria
        ]);

        // ✅ Guardar foto optimizada (si existe): se redimensiona/comprime a ~1MB
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->guardarFotoOptimizada($request->file('foto'), 'reportes_mantenimiento');
        }

        // ✅ Normalizar herramientas/materiales (vienen como string "a, b, c")
        $herramientas = $request->filled('herramientas')
            ? array_values(array_filter(array_map('trim', explode(',', $request->herramientas))))
            : [];

        $materiales = $request->filled('materiales')
            ? array_values(array_filter(array_map('trim', explode(',', $request->materiales))))
            : [];

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ]);

        // ✅ Normalizar herramientas/materiales (string separado por comas)
        $herramientas = $request->filled('herramientas')
            ? array_values(array_filter(array_map('trim', explode(',', $request->herramientas))))
            : [];

        $materiales = $request->filled('materiales')
            ? array_values(array_filter(array_map('trim', explode(',', $request->materiales))))
            : [];

        // ✅ Si sube nueva foto: borrar anterior + guardar nueva optimizada (~1MB)
        if ($request->hasFile('foto')) {
            if ($reporte->foto && Storage::disk('public')->exists($reporte->foto)) {
                Storage::disk('public')->delete($reporte->foto);
            }
            $reporte->foto = $this->guardarFotoOptimizada($request->file('foto'), 'reportes_mantenimiento');
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


/**
 * Redimensiona y comprime una foto subida para que ocupe como máximo ~1MB,
 * probando calidades JPEG decrecientes hasta bajar del límite (o llegar
 * al piso de calidad). Si GD no puede leer el archivo, lo guarda tal cual.
 */
private function guardarFotoOptimizada($file, string $folder, int $maxDim = 1920, int $maxBytes = 1024 * 1024): string
{
    $path = $file->getRealPath();
    $info = @getimagesize($path);

    if (!$info) {
        return $file->store($folder, 'public');
    }

    $imagen = match ($info[2]) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($path),
        IMAGETYPE_PNG => imagecreatefrompng($path),
        IMAGETYPE_WEBP => imagecreatefromwebp($path),
        default => null,
    };

    if (!$imagen) {
        return $file->store($folder, 'public');
    }

    // Corrige orientación EXIF (fotos de cámara suelen venir "rotadas" a nivel de metadata)
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($path);
        $orientacion = $exif['Orientation'] ?? null;
        $imagen = match ($orientacion) {
            3 => imagerotate($imagen, 180, 0),
            6 => imagerotate($imagen, -90, 0),
            8 => imagerotate($imagen, 90, 0),
            default => $imagen,
        };
    }

    // Redimensiona si excede el tamaño máximo permitido
    $ancho = imagesx($imagen);
    $alto = imagesy($imagen);
    $ratio = min($maxDim / $ancho, $maxDim / $alto, 1);

    if ($ratio < 1) {
        $nuevoAncho = (int) round($ancho * $ratio);
        $nuevoAlto = (int) round($alto * $ratio);
        $redimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagecopyresampled($redimensionada, $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagedestroy($imagen);
        $imagen = $redimensionada;
    }

    // Comprime iterativamente en JPEG hasta bajar de $maxBytes (o piso de calidad)
    $calidad = 85;
    do {
        ob_start();
        imagejpeg($imagen, null, $calidad);
        $datos = ob_get_clean();
        $calidad -= 10;
    } while (strlen($datos) > $maxBytes && $calidad >= 25);

    imagedestroy($imagen);

    $nombreArchivo = trim($folder, '/') . '/' . uniqid('foto_') . '.jpg';
    Storage::disk('public')->put($nombreArchivo, $datos);

    return $nombreArchivo;
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
