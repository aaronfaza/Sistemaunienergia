<?php

namespace App\Exports;

use App\Models\LogisticaLote;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title as ChartTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Hoja de indicadores del backup de ROP2026 Lote IX: KPIs de ejecución y
 * gráficas nativas de Excel (circulares y de línea) para evidenciar el
 * avance de los expedientes, complementando la hoja de datos crudos.
 */
class LogisticaDashboardSheet implements WithTitle, WithEvents, WithCharts
{
    private const FILA_TABLA_ESTADOS = 10;
    private const FILA_TABLA_CATEGORIAS = 29;
    private const FILA_TABLA_MENSUAL = 48;
    private const FILA_TABLA_AVANCE = 67;

    protected $registros;
    protected $total;
    protected $porEstado;
    protected $ejecutados;
    protected $anulados;
    protected $vencidosObservados;
    protected $enProceso;
    protected $pendientes;
    protected $promedioAvance;
    protected $porMes;
    protected $anioActual;

    public function __construct()
    {
        $this->registros = LogisticaLote::orderBy('id')->get();
        $this->total = $this->registros->count();

        $this->porEstado = collect(LogisticaLote::ESTADOS)->mapWithKeys(function ($estado) {
            return [$estado => $this->registros->where('estado', $estado)->count()];
        });

        $this->ejecutados = $this->porEstado['EJECUTADO'] ?? 0;
        $this->anulados = $this->porEstado['ANULADO'] ?? 0;
        $this->vencidosObservados = ($this->porEstado['ORDEN VENCIDA'] ?? 0) + ($this->porEstado['OBSERVADO'] ?? 0);
        $this->enProceso = $this->total - $this->ejecutados - $this->anulados - $this->vencidosObservados;
        $this->pendientes = $this->total - $this->ejecutados - $this->anulados;

        $this->promedioAvance = $this->total > 0
            ? round($this->registros->avg(fn ($r) => $r->porcentaje_ejecucion ?? 0), 1)
            : 0;

        $this->anioActual = now()->year;
        $this->porMes = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $this->porMes[$mes] = $this->registros->filter(function ($r) use ($mes) {
                return $r->created_at && $r->created_at->year === $this->anioActual && $r->created_at->month === $mes;
            })->count();
        }
    }

    public function title(): string
    {
        return 'Dashboard';
    }

    private function pct(int $parte): float
    {
        return $this->total > 0 ? round($parte / $this->total * 100, 1) : 0.0;
    }

    private function filaAvanceFin(): int
    {
        return self::FILA_TABLA_AVANCE + 1 + max($this->total, 1);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getColumnDimension('A')->setWidth(2);
                foreach (range('B', 'N') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(13);
                }

                $this->escribirEncabezado($sheet);
                $this->escribirKpis($sheet);
                $this->escribirTablaEstados($sheet);
                $this->escribirTablaCategorias($sheet);
                $this->escribirTablaMensual($sheet);
                $this->escribirTablaAvance($sheet);
            },
        ];
    }

    private function escribirEncabezado(Worksheet $sheet): void
    {
        $sheet->mergeCells('B1:N1');
        $sheet->setCellValue('B1', 'DASHBOARD ROP2026 LOTE IX — INDICADORES DE GESTIÓN');
        $sheet->getStyle('B1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '003366']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->mergeCells('B2:N2');
        $sheet->setCellValue('B2', 'Generado por ' . strtoupper(optional(Auth::user())->name ?? 'SISTEMA') . ' — ' . now('America/Lima')->format('d/m/Y H:i'));
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
    }

    private function escribirKpis(Worksheet $sheet): void
    {
        $sheet->mergeCells('B4:N4');
        $sheet->setCellValue('B4', 'INDICADORES CLAVE');
        $sheet->getStyle('B4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2EFDA']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $tarjetas = [
            ['B', 'TOTAL EXPEDIENTES', (string) $this->total],
            ['D', '% EJECUTADOS', $this->pct($this->ejecutados) . '%'],
            ['F', '% PENDIENTES', $this->pct($this->pendientes) . '%'],
            ['H', '% VENCIDOS/OBSERVADOS', $this->pct($this->vencidosObservados) . '%'],
            ['K', 'PROMEDIO % AVANCE', $this->promedioAvance . '%'],
        ];

        foreach ($tarjetas as [$col, $label, $valor]) {
            $colFin = chr(ord($col) + 1);
            $sheet->mergeCells("{$col}5:{$colFin}5");
            $sheet->setCellValue("{$col}5", $label);
            $sheet->getStyle("{$col}5")->applyFromArray([
                'font' => ['bold' => true, 'size' => 8, 'color' => ['rgb' => '475569']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            $sheet->mergeCells("{$col}6:{$colFin}6");
            $sheet->setCellValue("{$col}6", $valor);
            $sheet->getStyle("{$col}6")->applyFromArray([
                'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => '003366']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }
    }

    private function estiloTitulo(Worksheet $sheet, string $celda): void
    {
        $sheet->getStyle($celda)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '003366']],
        ]);
    }

    private function estiloHeaderTabla(Worksheet $sheet, string $rango): void
    {
        $sheet->getStyle($rango)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0369A1']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]],
        ]);
    }

    private function escribirTablaEstados(Worksheet $sheet): void
    {
        $fila = self::FILA_TABLA_ESTADOS;
        $sheet->setCellValue("B" . ($fila - 1), 'Distribución por Estado');
        $this->estiloTitulo($sheet, "B" . ($fila - 1));

        $sheet->setCellValue("B{$fila}", 'ESTADO');
        $sheet->setCellValue("C{$fila}", 'CANTIDAD');
        $this->estiloHeaderTabla($sheet, "B{$fila}:C{$fila}");

        $f = $fila + 1;
        foreach (LogisticaLote::ESTADOS as $estado) {
            $sheet->setCellValue("B{$f}", $estado);
            $sheet->setCellValue("C{$f}", $this->porEstado[$estado] ?? 0);
            $f++;
        }
    }

    private function escribirTablaCategorias(Worksheet $sheet): void
    {
        $fila = self::FILA_TABLA_CATEGORIAS;
        $sheet->setCellValue("B" . ($fila - 1), 'Ejecutados vs Pendientes vs Vencidos/Anulados');
        $this->estiloTitulo($sheet, "B" . ($fila - 1));

        $sheet->setCellValue("B{$fila}", 'CATEGORÍA');
        $sheet->setCellValue("C{$fila}", 'CANTIDAD');
        $this->estiloHeaderTabla($sheet, "B{$fila}:C{$fila}");

        $categorias = [
            'Ejecutado' => $this->ejecutados,
            'En proceso' => $this->enProceso,
            'Vencido/Observado' => $this->vencidosObservados,
            'Anulado' => $this->anulados,
        ];
        $f = $fila + 1;
        foreach ($categorias as $nombre => $cantidad) {
            $sheet->setCellValue("B{$f}", $nombre);
            $sheet->setCellValue("C{$f}", $cantidad);
            $f++;
        }
    }

    private function escribirTablaMensual(Worksheet $sheet): void
    {
        $fila = self::FILA_TABLA_MENSUAL;
        $sheet->setCellValue("B" . ($fila - 1), "Rendimiento Mensual — Expedientes creados en {$this->anioActual}");
        $this->estiloTitulo($sheet, "B" . ($fila - 1));

        $sheet->setCellValue("B{$fila}", 'MES');
        $sheet->setCellValue("C{$fila}", 'REGISTROS CREADOS');
        $this->estiloHeaderTabla($sheet, "B{$fila}:C{$fila}");

        $nombresMes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $f = $fila + 1;
        foreach ($nombresMes as $i => $nombre) {
            $sheet->setCellValue("B{$f}", $nombre);
            $sheet->setCellValue("C{$f}", $this->porMes[$i + 1] ?? 0);
            $f++;
        }
    }

    private function escribirTablaAvance(Worksheet $sheet): void
    {
        $fila = self::FILA_TABLA_AVANCE;
        $sheet->setCellValue("B" . ($fila - 1), '% de Avance por Expediente');
        $this->estiloTitulo($sheet, "B" . ($fila - 1));

        $sheet->setCellValue("B{$fila}", 'COD. LOG');
        $sheet->setCellValue("C{$fila}", '% AVANCE');
        $this->estiloHeaderTabla($sheet, "B{$fila}:C{$fila}");

        $f = $fila + 1;
        if ($this->total === 0) {
            $sheet->setCellValue("B{$f}", 'Sin expedientes registrados');
            $sheet->setCellValue("C{$f}", 0);
        } else {
            foreach ($this->registros as $registro) {
                $sheet->setCellValue("B{$f}", $registro->cod_log);
                $sheet->setCellValue("C{$f}", $registro->porcentaje_ejecucion ?? 0);
                $f++;
            }
        }
    }

    public function charts()
    {
        $titulo = $this->title();

        return [
            $this->grafico(
                'chartEstados',
                'Distribución por Estado',
                DataSeries::TYPE_PIECHART,
                "'{$titulo}'!\$B\$" . (self::FILA_TABLA_ESTADOS + 1) . ":\$B\$" . (self::FILA_TABLA_ESTADOS + count(LogisticaLote::ESTADOS)),
                "'{$titulo}'!\$C\$" . (self::FILA_TABLA_ESTADOS + 1) . ":\$C\$" . (self::FILA_TABLA_ESTADOS + count(LogisticaLote::ESTADOS)),
                count(LogisticaLote::ESTADOS),
                'E' . (self::FILA_TABLA_ESTADOS - 1),
                'M' . (self::FILA_TABLA_ESTADOS + 15)
            ),
            $this->grafico(
                'chartCategorias',
                'Tasa de Ejecutados vs Pendientes',
                DataSeries::TYPE_DOUGHNUTCHART,
                "'{$titulo}'!\$B\$" . (self::FILA_TABLA_CATEGORIAS + 1) . ":\$B\$" . (self::FILA_TABLA_CATEGORIAS + 4),
                "'{$titulo}'!\$C\$" . (self::FILA_TABLA_CATEGORIAS + 1) . ":\$C\$" . (self::FILA_TABLA_CATEGORIAS + 4),
                4,
                'E' . (self::FILA_TABLA_CATEGORIAS - 1),
                'M' . (self::FILA_TABLA_CATEGORIAS + 15)
            ),
            $this->grafico(
                'chartMensual',
                "Rendimiento Anual de ROP — {$this->anioActual}",
                DataSeries::TYPE_LINECHART,
                "'{$titulo}'!\$B\$" . (self::FILA_TABLA_MENSUAL + 1) . ":\$B\$" . (self::FILA_TABLA_MENSUAL + 12),
                "'{$titulo}'!\$C\$" . (self::FILA_TABLA_MENSUAL + 1) . ":\$C\$" . (self::FILA_TABLA_MENSUAL + 12),
                12,
                'E' . (self::FILA_TABLA_MENSUAL - 1),
                'N' . (self::FILA_TABLA_MENSUAL + 15)
            ),
            $this->grafico(
                'chartAvance',
                '% de Avance por Expediente',
                DataSeries::TYPE_BARCHART,
                "'{$titulo}'!\$B\$" . (self::FILA_TABLA_AVANCE + 1) . ":\$B\$" . ($this->filaAvanceFin() - 1),
                "'{$titulo}'!\$C\$" . (self::FILA_TABLA_AVANCE + 1) . ":\$C\$" . ($this->filaAvanceFin() - 1),
                max($this->total, 1),
                'E' . (self::FILA_TABLA_AVANCE - 1),
                'N' . (self::FILA_TABLA_AVANCE + 18)
            ),
        ];
    }

    private function grafico(
        string $id,
        string $titulo,
        string $tipo,
        string $rangoCategorias,
        string $rangoValores,
        int $cantidad,
        string $esquinaSuperiorIzquierda,
        string $esquinaInferiorDerecha
    ): Chart {
        $etiquetas = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [$titulo]);
        $categorias = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, $rangoCategorias, null, $cantidad);
        $valores = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, $rangoValores, null, $cantidad);

        $serie = new DataSeries(
            $tipo,
            $tipo === DataSeries::TYPE_LINECHART ? DataSeries::GROUPING_STANDARD : null,
            [0],
            [$etiquetas],
            [$categorias],
            [$valores]
        );

        $plotArea = new PlotArea(null, [$serie]);
        $leyenda = new Legend(Legend::POSITION_RIGHT, null, false);
        $tituloGrafico = new ChartTitle($titulo);

        $chart = new Chart($id, $tituloGrafico, $leyenda, $plotArea);
        $chart->setTopLeftPosition($esquinaSuperiorIzquierda);
        $chart->setBottomRightPosition($esquinaInferiorDerecha);

        return $chart;
    }
}
