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
        // Traemos todos los campos solicitados en el orden de los encabezados
        return LogisticaLote::select(
            'cod_log', 'carpeta', 'estado', 'responsable', 'numero_carta', 'asunto',
            'fecha_emision', 'codigo_unico', 'atencion', 'tipo_solicitud', 'nro_oc_os', 
            'emision_oc_os', 'ruc', 'empresa_ganadora', 'centro_costo', 'moneda', 
            'monto_igv', 'forma_pago', 'fecha_entrega', 'orden_firmada', 'conformidad', 
            'factura', 'monto_factura', 'fecha_vencimiento', 'porcentaje_ejecucion', 'observacion'
        )->get();
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            'COD. LOG', 'CARPETA', 'ESTADO', 'RESPONSABLE', 'N° CARTA', 'ASUNTO',
            'F. EMISIÓN', 'CÓD. ÚNICO', 'ATENCIÓN', 'TIPO SOLICITUD', 'N° OC/OS',
            'F. OC/OS', 'RUC', 'PROVEEDOR', 'C. COSTO', 'MONEDA',
            'MONTO IGV', 'FORMA PAGO', 'F. ENTREGA', 'ORD. FIRMADA', 'CONFORMIDAD',
            'FACTURA', 'MONTO FACT.', 'F. VENC.', '% EJEC.', 'OBSERVACIÓN'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 12, 'C' => 15, 'D' => 20, 'E' => 15, 'F' => 35,
            'G' => 13, 'H' => 15, 'I' => 20, 'J' => 15, 'K' => 15, 'L' => 13,
            'M' => 15, 'N' => 30, 'O' => 15, 'P' => 10, 'Q' => 15, 'R' => 15,
            'S' => 13, 'T' => 12, 'U' => 20, 'V' => 15, 'W' => 15, 'X' => 13,
            'Y' => 10, 'Z' => 40,
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
            // Bordes generales (Hasta columna Z que es Observación)
            'A6:Z1000' => [
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

                // 1. Barra Verde Neón (Se extiende hasta Z)
                $sheet->mergeCells('A1:Z1');
                $sheet->setCellValue('A1', '\\\\hp-server\\Operaciones\\LOGISTICA\\REPORTE_COMPLETO_2025');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'italic' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '00FF00']]
                ]);

                // 2. Título Central
                $sheet->mergeCells('A2:Z2');
                $sheet->setCellValue('A2', 'BACKUP INTEGRAL DE GESTIÓN LOGÍSTICA - UNIENERGIA ABC');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // 3. Información de Usuario
                $sheet->setCellValue('A3', 'USUARIO: ' . strtoupper($user->name));
                $sheet->setCellValue('A4', 'CARGO: ' . strtoupper($user->cargo ?? 'ANALISTA LOGÍSTICO'));
                $sheet->setCellValue('E3', 'FECHA: ' . $now->format('d/m/Y'));
                $sheet->setCellValue('E4', 'HORA: ' . $now->format('H:i:s'));

                // 4. Barra de Secciones de Colores
                // Sección Logística
                $sheet->mergeCells('A5:I5');
                $sheet->setCellValue('A5', 'IDENTIFICACIÓN Y TRÁMITE');
                // Sección Comercial
                $sheet->mergeCells('J5:R5');
                $sheet->setCellValue('J5', 'DATOS COMERCIALES Y PROVEEDOR');
                // Sección Seguimiento
                $sheet->mergeCells('S5:Z5');
                $sheet->setCellValue('S5', 'ESTADO DE EJECUCIÓN Y CONTABLE');

                $sheet->getStyle('A5:Z5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2EFDA']]
                ]);
                
                // Formato numérico para Moneda (Columna Q - Monto IGV y W - Monto Factura)
                $sheet->getStyle('Q7:Q1000')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('W7:W1000')->getNumberFormat()->setFormatCode('#,##0.00');
            },
        ];
    }
}