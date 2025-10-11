
<?php


use App\Models\ControlCarta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ControlCartasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Retorna la colección de datos a exportar
     */
    public function collection()
    {
        return ControlCarta::all();
    }

    /**
     * Define las cabeceras del archivo Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'N° Carta',
            'Fecha de Emisión',
            'Destinatario',
            'Asunto',
            'Área Responsable',
            'Estado',
            'Observaciones',
            'Fecha de Registro',
        ];
    }

    /**
     * Mapea cada fila de datos a las columnas del Excel
     */
    public function map($controlCarta): array
    {
        return [
            $controlCarta->id,
            $controlCarta->numero_carta,
            $controlCarta->fecha_emision,
            $controlCarta->destinatario,
            $controlCarta->asunto,
            $controlCarta->area_responsable,
            $controlCarta->estado,
            $controlCarta->observaciones,
            $controlCarta->created_at ? $controlCarta->created_at->format('d/m/Y H:i') : '',
        ];
    }
}
