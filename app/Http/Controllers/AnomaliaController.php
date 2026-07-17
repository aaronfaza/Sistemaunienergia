<?php

namespace App\Http\Controllers;

use App\Models\Anomalia;
use App\Traits\OptimizaFoto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnomaliaController extends Controller
{
    use OptimizaFoto;

    public function index(Request $request)
    {
        $query = Anomalia::query();

        if ($request->filled('pozo')) {
            $query->where('pozo', 'like', '%' . $request->pozo . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $anomalias = $query->orderByDesc('id')->get();
        $totalAnomalias = $anomalias->count();
        $totalPendientes = $anomalias->where('estado', 'Pendiente')->count();

        return view('anomalias.index', compact('anomalias', 'totalAnomalias', 'totalPendientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pozo' => 'required|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'gravedad' => 'required|in:Baja,Media,Alta,Crítica',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->guardarFotoOptimizada($request->file('foto'), 'anomalias');
        }

        Anomalia::create([
            'nombre' => Auth::user()->name,
            'pozo' => $request->pozo,
            'tipo_equipo' => $request->tipo_equipo,
            'gravedad' => $request->gravedad,
            'descripcion' => $request->descripcion,
            'foto' => $fotoPath,
            'estado' => 'Pendiente',
        ]);

        return redirect()->route('anomalias.index')->with('success', 'Anomalía reportada correctamente.');
    }

    public function updateEstado(Request $request, Anomalia $anomalia)
    {
        abort_if(Auth::user()->esSoloMantenimiento(), 403, 'No tienes permiso para cambiar el estado de una anomalía.');

        $request->validate([
            'estado' => 'required|in:Pendiente,En Atención,Resuelta',
        ]);

        $anomalia->estado = $request->estado;
        $anomalia->save();

        return back()->with('success', 'Estado actualizado correctamente.');
    }

    public function show(Anomalia $anomalia)
    {
        $pdf = Pdf::loadView('anomalias.pdf', compact('anomalia'));
        return $pdf->stream("anomalia_{$anomalia->id}.pdf");
    }

    public function pdf(Anomalia $anomalia)
    {
        abort_if(Auth::user()->esSoloMantenimiento(), 403, 'No tienes permiso para descargar este reporte.');

        $pdf = Pdf::loadView('anomalias.pdf', compact('anomalia'));
        return $pdf->download('anomalia_' . $anomalia->id . '.pdf');
    }

    public function destroy(Anomalia $anomalia)
    {
        abort_if(Auth::user()->esSoloMantenimiento(), 403, 'No tienes permiso para eliminar anomalías.');

        if ($anomalia->foto && Storage::disk('public')->exists($anomalia->foto)) {
            Storage::disk('public')->delete($anomalia->foto);
        }

        $anomalia->delete();

        return redirect()->route('anomalias.index')->with('success', 'Anomalía eliminada correctamente.');
    }
}
