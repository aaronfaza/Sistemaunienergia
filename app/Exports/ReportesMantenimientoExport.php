<?php

namespace App\Exports;

use App\Models\ReporteMantenimiento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportesMantenimientoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    private string $empresa;
    private string $generadoPor;
    private string $generadoEn;

    public function __construct(string $empresa, string $generadoPor, string $generadoEn)
    {
        $this->empresa = $empresa;
        $this->generadoPor = $generadoPor;
        $this->generadoEn = $generadoEn;
    }

    public function collection(): Collection
    {
        return ReporteMantenimiento::orderByDesc('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Título',
            'Fecha Inicio',
            'Fecha Término',
            'Ubicación',
            'Tipo de Equipo',
            'Rotulado',
            'Herramientas',
            'Materiales',
            'Descripción Actividad',
            'Foto',
            'Firma',
            'Creado (Fecha/Hora)',
        ];
    }

    public function map($r): array
    {
        return [
            $r->id,
            $r->nombre,
            $r->titulo,
            $r->fecha_inicio,
            $r->fecha_termino,
            $r->ubicacion,
            $r->tipo_equipo,
            $r->rotulado,
            is_array($r->herramientas) ? implode(', ', $r->herramientas) : (string)$r->herramientas,
            is_array($r->materiales) ? implode(', ', $r->materiales) : (string)$r->materiales,
            $r->descripcion_actividad,
            $r->foto ? ('storage/'.$r->foto) : '',
            $r->firma ? ('storage/'.$r->firma) : '',
            optional($r->created_at)->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezado en negrita + centrado
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal('center');
        $sheet->getRowDimension(1)->setRowHeight(18);

        // Ajuste de ancho aproximado
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Congelar header
        $sheet->freezePane('A2');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header/Footer (lo “posterior” correcto en Excel)
                $header = "&L&8{$this->empresa}&R&8Backup Reportes";
                $footer = "&L&8Generado por: {$this->generadoPor}"
                        . "&R&8{$this->generadoEn}";

                $sheet->getHeaderFooter()->setOddHeader($header);
                $sheet->getHeaderFooter()->setOddFooter($footer);

                // Opcional: repetir header al imprimir
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
            },
        ];
    }
}
