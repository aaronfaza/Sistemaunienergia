<?php

namespace App\Exports;

use App\Models\ControlCarta;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ControlCartasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
{
    protected $buscar;

    public function __construct($buscar = null)
    {
        $this->buscar = $buscar;
    }

    /**
     * Datos a exportar
     */
    public function collection()
    {
        return ControlCarta::when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('codigo', 'like', "%{$this->buscar}%")
                      ->orWhere('mes', 'like', "%{$this->buscar}%")
                      ->orWhere('servicio_compra', 'like', "%{$this->buscar}%")
                      ->orWhere('descripcion', 'like', "%{$this->buscar}%")
                      ->orWhere('proveedor_elegido', 'like', "%{$this->buscar}%")
                      ->orWhere('nro_orden', 'like', "%{$this->buscar}%")
                      ->orWhere('autorizado_por', 'like', "%{$this->buscar}%")
                      ->orWhere('area', 'like', "%{$this->buscar}%");
                });
            })
            ->orderBy('fecha', 'desc')
            ->get();
    }

    /**
     * Cabeceras
     */
    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Fecha',
            'Mes',
            'Servicio / Compra',
            'Descripción',
            'Proveedor',
            'Cotizaciones',
            'Equipo',
            'Especificación',
            'Monto S/',
            'Monto $',
            'N° Orden',
            'Autorizado por',
            'Factura',
            'Fecha Recepción',
            'Fecha Vencimiento',
            'Fecha Pago',
            'Área',
            'Registrado el'
        ];
    }

    /**
     * Mapeo de filas
     */
    public function map($carta): array
    {
        return [
            $carta->id,
            $carta->codigo,
            optional($carta->fecha)->format('d/m/Y'),
            $carta->mes,
            $carta->servicio_compra,
            $carta->descripcion,
            $carta->proveedor_elegido,
            $carta->cotizaciones_consideradas,
            $carta->equipo,
            $carta->especificacion,
            $carta->monto_soles,
            $carta->monto_dolares,
            $carta->nro_orden,
            $carta->autorizado_por,
            $carta->factura_nro,
            optional($carta->fecha_recepcion)->format('d/m/Y'),
            optional($carta->fecha_vencimiento)->format('d/m/Y'),
            optional($carta->fecha_pago)->format('d/m/Y'),
            $carta->area,
            optional($carta->created_at)->format('d/m/Y H:i'),
        ];
    }

    /**
     * Estilos + metadata
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Encabezado corporativo
                $sheet->insertNewRowBefore(1, 3);

                $sheet->setCellValue('A1', 'UNIENERGIA ABC');
                $sheet->setCellValue('A2', 'Backup de Cartas SO-PRO');
                $sheet->setCellValue('A3', 'Generado por: ' . Auth::user()->name . ' | Área: ' . Auth::user()->cargo . ' | ' . now()->format('d/m/Y H:i'));

                $sheet->mergeCells('A1:T1');
                $sheet->mergeCells('A2:T2');
                $sheet->mergeCells('A3:T3');

                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A4:T4')->getFont()->setBold(true);

                $sheet->freezePane('A5');
            }
        ];
    }
}
