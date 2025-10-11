<?php

namespace App\Exports;

use App\Models\Requerimiento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RequerimientosExport implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        // 🔹 Datos adicionales para el encabezado del Excel
        $empresa = 'UNIENERGIA SAC';
        $usuario = Auth::user()->name ?? 'Usuario desconocido';
        $fecha = Carbon::now()->format('d/m/Y H:i:s');

        // 🔹 Trae todos los requerimientos con sus detalles (sin relaciones inexistentes)
        $requerimientos = Requerimiento::with('detalles')->orderBy('id', 'desc')->get();

        return view('requerimientos.excel', [
            'requerimientos' => $requerimientos,
            'empresa' => $empresa,
            'usuario' => $usuario,
            'fecha' => $fecha,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
