<?php

namespace App\Http\Controllers;

use App\Models\CartaFis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

// IMPORTANTE: Estas clases son necesarias para el Excel
use App\Exports\CartasFisExport;
use Maatwebsite\Excel\Facades\Excel;

class CartaFisController extends Controller
{
    /**
     * Mostrar listado con buscador y paginación
     */
    public function index(Request $request)
    {
        $query = CartaFis::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('servicio_compra', 'like', "%{$buscar}%")
                  ->orWhere('proveedor_elegido', 'like', "%{$buscar}%")
                  ->orWhere('area', 'like', "%{$buscar}%");
            });
        }

        $cartas = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('cartas_fis.index', compact('cartas'));
    }

    /**
     * Registrar una nueva Carta FIS
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:255|unique:cartas_fis,codigo',
            'fecha' => 'required|date',
            'mes' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'servicio_compra' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string|max:255',
            'cotizaciones_consideradas' => 'nullable|string|max:255',
            'equipo' => 'nullable|string|max:255',
            'especificacion' => 'nullable|string|max:255',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string|max:255',
            'autorizado_por' => 'nullable|string|max:255',
            'factura_nro' => 'nullable|string|max:255',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'estado' => 'nullable|in:Pendiente,Rechazado,Ejecutado',
        ]);

        $data['created_by'] = Auth::id();
        CartaFis::create($data);

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS registrada correctamente.');
    }

    /**
     * Actualizar una Carta FIS existente
     */
    public function update(Request $request, $id)
    {
        $carta = CartaFis::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'required|string|max:255|unique:cartas_fis,codigo,'.$carta->id,
            'fecha' => 'required|date',
            'mes' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'servicio_compra' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string|max:255',
            'cotizaciones_consideradas' => 'nullable|string|max:255',
            'equipo' => 'nullable|string|max:255',
            'especificacion' => 'nullable|string|max:255',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string|max:255',
            'autorizado_por' => 'nullable|string|max:255',
            'factura_nro' => 'nullable|string|max:255',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'estado' => 'required|in:Pendiente,Rechazado,Ejecutado',
        ]);

        $data['updated_by'] = Auth::id();
        $carta->update($data);

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS actualizada correctamente.');
    }

    /**
     * Eliminar una carta
     */
    public function destroy($id)
    {
        $carta = CartaFis::findOrFail($id);
        $carta->delete();
        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS eliminada.');
    }

    /**
     * Exportar a Excel con diseño (vía Maatwebsite)
     */
    public function exportExcel()
    {
        $filename = "Reporte_FIS_" . now()->format('Y-m-d_His') . ".xlsx";
        return Excel::download(new CartasFisExport, $filename);
    }

    /**
     * Generar un Backup en CSV (Compatible con Excel)
     */
    public function backup()
    {
        $table = CartaFis::all();
        $filename = "backup_cartas_fis_" . now()->format('Y-m-d_H-i-s') . ".csv";

        $callback = function() use ($table) {
            $handle = fopen('php://output', 'w');
            // Añadir el BOM para que Excel detecte UTF-8 (tildes y eñes)
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Encabezados
            fputcsv($handle, [
                'ID', 'Código', 'Fecha', 'Mes', 'Área', 'Servicio/Compra', 'Descripción', 
                'Proveedor', 'Monto S/', 'Monto $', 'Estado', 'Creado por'
            ]);

            foreach ($table as $row) {
                fputcsv($handle, [
                    $row->id, $row->codigo, $row->fecha, $row->mes, $row->area, 
                    $row->servicio_compra, $row->descripcion, $row->proveedor_elegido, 
                    $row->monto_soles, $row->monto_dolares, $row->estado, $row->created_by
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}