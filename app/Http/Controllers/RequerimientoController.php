<?php

namespace App\Http\Controllers;

use App\Models\Requerimiento;
use App\Models\DetalleRequerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RequerimientoController extends Controller
{
    /**
     * Listado con filtros y paginación.
     * Filtros: codigo, fecha, area_solicitante, nombre_solicitante.
     */
    public function index(Request $request)
    {
       
         $codigo  = trim((string) $request->get('codigo', ''));
    $fecha   = trim((string) $request->get('fecha', ''));
    $area    = trim((string) $request->get('area_solicitante', ''));
    $nombre  = trim((string) $request->get('nombre_solicitante', ''));

    $query = Requerimiento::query();

    if ($codigo !== '') {
        $query->where('codigo', 'like', "%{$codigo}%");
    }

    if ($fecha !== '') {
        $query->whereDate('fecha', $fecha);
    }

    if ($area !== '') {
        $query->where('area_solicitante', 'like', "%{$area}%");
    }

    if ($nombre !== '') {
        $query->where('nombre_solicitante', 'like', "%{$nombre}%");
    }

    $totalRequerimientos = $query->count();

    $requerimientos = $query
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString();

    // para tu dropdown de notificaciones
    $notificaciones = Requerimiento::latest()->take(5)->get();

    // ====== KPI / DASHBOARD (globales, sin filtros) ======
    $total    = Requerimiento::count();
    $hoy      = Requerimiento::whereDate('created_at', now()->toDateString())->count();
    $esteMes  = Requerimiento::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

    // Top de áreas con más requerimientos
    $porArea = Requerimiento::select('area_solicitante as area', DB::raw('COUNT(*) as total'))
        ->groupBy('area')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    // Últimos requerimientos
    $recientes = Requerimiento::select('id','codigo','area_solicitante','nombre_solicitante','created_at')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    return view('requerimientos.index', compact(
        // Listado + filtros
        'requerimientos',
        'totalRequerimientos',
        'notificaciones',
        // Dashboard
        'total',
        'hoy',
        'esteMes',
        'porArea',
        'recientes'
    ));

    }

    /** Vista de creación (si la usas). */
    public function create()
    {
        return view('requerimientos.create');
    }

    /**
     * Guardar requerimiento + detalles.
     * - destino[] (checkboxes) se guarda como string: "Lote IX, Oficina, ..."
     * - detalles[] se guarda en detalle_requerimientos (createMany)
     */
    public function store(Request $request)
    {
        // Nombre del usuario logueado (lo forzamos por seguridad)
        $request->merge([
            'nombre_solicitante' => Auth::user()->name ?? $request->nombre_solicitante,
            'user_id' => Auth::id(),
        ]);

        $request->validate([
            'codigo'             => 'required|string', // sin unique 
            'fecha'              => 'required|date',
            'area_solicitante'   => 'required|string',
            'nombre_solicitante' => 'required|string',
            'cargo_solicitante'  => 'required|string',
            'servicio'           => 'required|in:Compra,Servicio',
            'destino'            => 'required|array|min:1',
            'destino.*'          => 'in:Lote IX,Oficina,Unidad vehicular,Vivienda',
            'sustento'           => 'nullable|string',

            // Detalles
            'detalles'                     => 'required|array|min:1',
            'detalles.*.descripcion'       => 'required|string|max:500',
            'detalles.*.identificacion'    => 'nullable|string|max:255',
            'detalles.*.cantidad'          => 'required|integer|min:1',
            'detalles.*.unidad'            => 'nullable|string|max:50',
        ], [
            'destino.required' => 'Seleccione al menos un destino.',
            'detalles.required' => 'Agregue al menos un ítem en el detalle.',
        ]);

        $destinoStr = implode(', ', $request->input('destino', []));

        DB::transaction(function () use ($request, $destinoStr) {
            $req = Requerimiento::create([
                'codigo'             => $request->codigo,
                'fecha'              => $request->fecha,
                'area_solicitante'   => $request->area_solicitante,
                'nombre_solicitante' => $request->nombre_solicitante,
                'cargo_solicitante'  => $request->cargo_solicitante,
                'servicio'           => $request->servicio,
                'destino'            => $destinoStr,
                'sustento'           => $request->sustento,
                'user_id'            => $request->user_id, // si tu tabla lo tiene
            ]);

            // Guarda todos los ítems del detalle
            $req->detalles()->createMany($request->detalles);
        });

        return redirect()->route('requerimientos.index')
            ->with('success', 'Requerimiento creado correctamente.');
    }

    /**
     * (Opcional) Si tu botón "Ver" abre el PDF,
     * devolvemos el mismo PDF en modo stream.
     */
    public function show($id)
    {
        $req = Requerimiento::with('detalles')->findOrFail($id);
        $pdf = Pdf::loadView('requerimientos.pdf', compact('req'));
        return $pdf->stream("requerimiento-{$req->codigo}-{$req->id}.pdf");
    }

    /** Vista de edición (si la usas). */
    public function edit($id)
    {
        $req = Requerimiento::with('detalles')->findOrFail($id);
        return view('requerimientos.edit', compact('req'));
    }

    /**
     * Actualizar requerimiento + detalles.
     * Reemplazamos los detalles por simplicidad (delete + createMany).
     */
    public function update(Request $request, $id)
    {
        $req = Requerimiento::with('detalles')->findOrFail($id);

        $request->validate([
            'codigo'             => 'required|string',
            'fecha'              => 'required|date',
            'area_solicitante'   => 'required|string',
            'nombre_solicitante' => 'required|string',
            'cargo_solicitante'  => 'required|string',
            'servicio'           => 'required|in:Compra,Servicio',
            'destino'            => 'required|array|min:1',
            'destino.*'          => 'in:Lote IX,Oficina,Unidad vehicular,Vivienda',
            'sustento'           => 'nullable|string',

            'detalles'                     => 'required|array|min:1',
            'detalles.*.descripcion'       => 'required|string|max:500',
            'detalles.*.identificacion'    => 'nullable|string|max:255',
            'detalles.*.cantidad'          => 'required|integer|min:1',
            'detalles.*.unidad'            => 'nullable|string|max:50',
        ]);

        $destinoStr = implode(', ', $request->input('destino', []));

        DB::transaction(function () use ($req, $request, $destinoStr) {
            $req->update([
                'codigo'             => $request->codigo,
                'fecha'              => $request->fecha,
                'area_solicitante'   => $request->area_solicitante,
                'nombre_solicitante' => $request->nombre_solicitante,
                'cargo_solicitante'  => $request->cargo_solicitante,
                'servicio'           => $request->servicio,
                'destino'            => $destinoStr,
                'sustento'           => $request->sustento,
            ]);

            // Reemplazar detalles
            $req->detalles()->delete();
            $req->detalles()->createMany($request->detalles);
        });

        return redirect()->route('requerimientos.index')
            ->with('success', 'Requerimiento actualizado correctamente.');
    }

    /**
     * Eliminar (si FK tiene onDelete('cascade'), borra detalles).
     */
    public function destroy($id)
    {
        $req = Requerimiento::findOrFail($id);
        $req->delete();

        return redirect()->route('requerimientos.index')
            ->with('success', 'Requerimiento eliminado correctamente.');
    }

    /**
     * Impresión del requerimiento en PDF (descarga).
     * La vista usada es 'requerimientos.pdf'.
     */
    public function imprimir($id)
    {
        $req = Requerimiento::with('detalles')->findOrFail($id);
        $pdf = Pdf::loadView('requerimientos.pdf', compact('req'));
        // stream() para abrir en el navegador; download() para descargar
        return $pdf->download("requerimiento-{$req->codigo}-{$req->id}.pdf");
    }
}
