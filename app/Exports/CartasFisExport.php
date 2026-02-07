<?php

namespace App\Exports;

use App\Models\CartaFis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CartasFisExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CartaFis::all();
    }

    /**
    * Mapeo de cada columna de la base de datos
    */
    public function map($carta): array
    {
        return [
            $carta->id,
            $carta->codigo,
            $carta->fecha ? \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') : '',
            $carta->mes,
            $carta->area,
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
            $carta->fecha_recepcion ? \Carbon\Carbon::parse($carta->fecha_recepcion)->format('d/m/Y') : '',
            $carta->fecha_vencimiento ? \Carbon\Carbon::parse($carta->fecha_vencimiento)->format('d/m/Y') : '',
            $carta->fecha_pago ? \Carbon\Carbon::parse($carta->fecha_pago)->format('d/m/Y') : '',
            $carta->estado,
            $carta->created_at ? \Carbon\Carbon::parse($carta->created_at)->format('d/m/Y H:i') : '',
            now()->format('d/m/Y H:i:s'), // Fecha de descarga
        ];
    }

    /**
    * Encabezados con todos los campos de la tabla
    */
    public function headings(): array
    {
        return [
            ['REPORTE DETALLADO DE CARTAS FIS - UNI ENERGIA'],
            ['Generado el: ' . now()->format('d/m/Y H:i')],
            [], // Fila vacía para separación
            [
                'ID',
                'CÓDIGO',
                'FECHA EMISIÓN',
                'MES',
                'ÁREA',
                'SERVICIO/COMPRA',
                'DESCRIPCIÓN',
                'PROVEEDOR ELEGIDO',
                'COTIZACIONES',
                'EQUIPO',
                'ESPECIFICACIÓN',
                'MONTO S/',
                'MONTO $',
                'NRO ORDEN',
                'AUTORIZADO POR',
                'NRO FACTURA',
                'FECHA RECEPCIÓN',
                'FECHA VENC.',
                'FECHA PAGO',
                'ESTADO',
                'FECHA REGISTRO',
                'FECHA EXPORTACIÓN'
            ]
        ];
    }

    /**
    * Estilos para que el reporte se vea profesional
    */
    public function styles(Worksheet $sheet)
    {
        // Combinar celdas para el título principal (A1 hasta V1)
        $sheet->mergeCells('A1:V1');
        $sheet->mergeCells('A2:V2');

        return [
            // Estilo para el título principal
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '003366']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            
            // Estilo para la fila de encabezados de la tabla (Fila 4)
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1d4e89']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],

            // Bordes para toda la tabla (dinámico hasta la última fila con datos)
            'A4:V' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}