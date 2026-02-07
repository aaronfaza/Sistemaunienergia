<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\ControlCarta;
use App\Exports\ControlCartasExport;
use Maatwebsite\Excel\Facades\Excel;

class ControlCartaController extends Controller
{
    /**
     * Listado + buscador
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

    $cartas = ControlCarta::when($buscar, function ($query, $buscar) {
            $query->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('servicio_compra', 'like', "%{$buscar}%")
                  ->orWhere('proveedor_elegido', 'like', "%{$buscar}%");
        })
        ->orderBy('fecha', 'desc')
        ->paginate(10) // 👈 cantidad de registros por página
        ->withQueryString(); // 👈 mantiene el buscador al paginar

    return view('control_cartas.index', compact('cartas', 'buscar'));
    }

    /**
     * Guardar carta
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['estado'] = $data['estado'] ?? 'Pendiente';
        ControlCarta::create($data);

        $request->validate([
            'codigo' => 'required|unique:control_cartas,codigo',
            'fecha' => 'required|date',
            'mes' => 'nullable|string',
            'servicio_compra' => 'required|string',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string',
            'cotizaciones_consideradas' => 'nullable|string',
            'equipo' => 'nullable|string',
            'especificacion' => 'nullable|string',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string',
            'autorizado_por' => 'nullable|string',
            'factura_nro' => 'nullable|string',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'area' => 'nullable|string',
        ]);

        ControlCarta::create($request->all());

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta registrada correctamente.');
    }

    /**
     * Actualizar carta
     */
    public function update(Request $request, $id)
    {
        $carta = ControlCarta::findOrFail($id);

        $request->validate([
            'codigo' => 'required|unique:control_cartas,codigo,' . $carta->id,
            'fecha' => 'required|date',
            'servicio_compra' => 'required|string',
        ]);

        $carta->update($request->all());

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta actualizada correctamente.');
    }

    /**
     * Eliminar carta
     */
    public function destroy($id)
    {
        ControlCarta::findOrFail($id)->delete();

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta eliminada correctamente.');
    }

    /**
     * Exportar Excel (backup)
     */
    public function exportExcel(Request $request)
    {
        $buscar = $request->get('buscar');

        return Excel::download(
            new ControlCartasExport($buscar),
            'backup_cartas_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdfIndividual($id)
        {
            $carta = ControlCarta::findOrFail($id);

            $pdf = Pdf::loadView('control_cartas.pdf_individual', compact('carta'))
                    ->setPaper('a4', 'portrait');

            return $pdf->download('Carta_SO_PRO_' . $carta->codigo . '.pdf');
        }

        public function updateEstado(Request $request, $id)
        {
            $request->validate([
                'estado' => 'required|in:Pendiente,Rechazado,Ejecutado'
            ]);

            $carta = ControlCarta::findOrFail($id);
            $carta->estado = $request->estado;
            $carta->save();

            return back();
        }




}
