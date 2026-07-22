<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Backup completo de ROP2026 Lote IX: hoja de datos crudos (mismo diseño
 * corporativo usado en la hoja de cálculo original del equipo) + hoja de
 * indicadores con KPIs y gráficas nativas de Excel.
 */
class LogisticaBackupExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new LogisticaExport(),
            new LogisticaDashboardSheet(),
        ];
    }
}
