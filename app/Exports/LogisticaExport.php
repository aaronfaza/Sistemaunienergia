<?php

namespace App\Exports;

use App\Models\LogisticaLote;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogisticaExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        // Traemos todos los campos solicitados en el orden de los encabezados.
        // RESPONSABLE se resuelve desde la relación (usuario que tiene pendiente
        // firmar), no desde la columna `responsable` (texto libre, en desuso).
        return LogisticaLote::with('responsableFirma')->get()->map(function ($lote) {
            return [
                $lote->cod_log,
                $lote->carpeta,
                $lote->estado,
                $lote->servicio_valorizacion,
                $lote->responsableFirma->name ?? null,
                $lote->numero_carta,
                $lote->asunto,
                $lote->fecha_emision,
                $lote->codigo_unico,
                $lote->atencion,
                $lote->tipo_solicitud,
                $lote->nro_oc_os,
                $lote->emision_oc_os,
                $lote->ruc,
                $lote->empresa_ganadora,
                $lote->centro_costo,
                $lote->moneda,
                $lote->monto_igv,
                $lote->forma_pago,
                $lote->fecha_entrega,
                $lote->orden_firmada,
                $lote->conformidad,
                $lote->factura,
                $lote->monto_factura,
                $lote->fecha_vencimiento,
                $lote->fecha_pago,
                $lote->porcentaje_ejecucion,
                $lote->observacion,
            ];
        });
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            'COD. LOG', 'CARPETA', 'ESTADO', 'SERV. VALORIZ.', 'RESPONSABLE (FIRMA PEND.)', 'N° CARTA', 'ASUNTO',
            'F. EMISIÓN', 'CÓD. ÚNICO', 'ATENCIÓN', 'TIPO SOLICITUD', 'N° OC/OS',
            'F. OC/OS', 'RUC', 'PROVEEDOR', 'C. COSTO', 'MONEDA',
            'MONTO IGV', 'FORMA PAGO', 'F. ENTREGA', 'ORD. FIRMADA', 'CONFORMIDAD',
            'FACTURA', 'MONTO FACT.', 'F. VENC.', 'F. PAGO', '% EJEC.', 'OBSERVACIÓN'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 12, 'C' => 15, 'D' => 18, 'E' => 20, 'F' => 15, 'G' => 35,
            'H' => 13, 'I' => 15, 'J' => 20, 'K' => 15, 'L' => 15, 'M' => 13,
            'N' => 15, 'O' => 30, 'P' => 15, 'Q' => 10, 'R' => 15, 'S' => 15,
            'T' => 13, 'U' => 12, 'V' => 20, 'W' => 15, 'X' => 15, 'Y' => 13,
            'Z' => 13, 'AA' => 10, 'AB' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Encabezados Azul Marino
            6 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '003366']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
            // Bordes generales (hasta AB, que es Observación)
            'A6:AB1000' => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $now = Carbon::now('America/Lima');
                $user = Auth::user();

                // 1. Barra Verde Neón (se extiende hasta AB)
                $sheet->mergeCells('A1:AB1');
                $sheet->setCellValue('A1', '\\\\hp-server\\Operaciones\\LOGISTICA\\REPORTE_COMPLETO_2025');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'italic' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '00FF00']]
                ]);

                // 2. Título Central
                $sheet->mergeCells('A2:AB2');
                $sheet->setCellValue('A2', 'BACKUP INTEGRAL DE GESTIÓN LOGÍSTICA - UNIENERGIA ABC');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // 3. Información de Usuario
                $sheet->setCellValue('A3', 'USUARIO: ' . strtoupper($user->name));
                $sheet->setCellValue('A4', 'CARGO: ' . strtoupper($user->cargo ?? 'ANALISTA LOGÍSTICO'));
                $sheet->setCellValue('E3', 'FECHA: ' . $now->format('d/m/Y'));
                $sheet->setCellValue('E4', 'HORA: ' . $now->format('H:i:s'));

                // 4. Barra de Secciones de Colores
                // Sección Logística (cod_log..atencion)
                $sheet->mergeCells('A5:J5');
                $sheet->setCellValue('A5', 'IDENTIFICACIÓN Y TRÁMITE');
                // Sección Comercial (tipo_solicitud..forma_pago)
                $sheet->mergeCells('K5:S5');
                $sheet->setCellValue('K5', 'DATOS COMERCIALES Y PROVEEDOR');
                // Sección Seguimiento (fecha_entrega..observacion)
                $sheet->mergeCells('T5:AB5');
                $sheet->setCellValue('T5', 'ESTADO DE EJECUCIÓN Y CONTABLE');

                $sheet->getStyle('A5:AB5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2EFDA']]
                ]);

                // Formato numérico (columna R - Monto IGV y X - Monto Factura)
                $sheet->getStyle('R7:R1000')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('X7:X1000')->getNumberFormat()->setFormatCode('#,##0.00');
            },
        ];
    }
}