<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteMantenimientoController;
use App\Http\Controllers\InspeccionVehicularController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\DashboardWelcomeController;
use App\Http\Controllers\ControlCartaController;
use App\Http\Controllers\CartaFisController;
use App\Http\Controllers\CartaIpfController;
use App\Http\Controllers\CartaManController;
use App\Http\Controllers\CartaLogController;
use App\Http\Controllers\LogisticaLoteController;
use App\Http\Controllers\AnomaliaController;
use App\Http\Controllers\FirmaSupervisorController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\BoletaController;

// Redirect al login por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Área autenticada
Route::middleware(['auth', 'rol.restriccion'])->group(function () {

    // Dashboard (si tu dashboard muestra los reportes existentes)
    Route::get('/dashboard', [ReporteMantenimientoController::class, 'index'])
        ->name('dashboard');

    Route::get('/reportes/backup-excel', [ReporteMantenimientoController::class, 'backupExcel'])
    ->name('reportes.backup.excel');

    // Reportes de mantenimiento mecánico (tu caso anterior)
    Route::resource('reportes', ReporteMantenimientoController::class);

    // PDF de reporte
    Route::get('/reportes/{id}/pdf', [ReporteMantenimientoController::class, 'pdf'])
        ->name('reportes.pdf');

    // Firma local del supervisor de mantenimiento
    Route::post('/mi-firma', [FirmaSupervisorController::class, 'guardar'])
        ->name('firma.guardar');

    // Perfil de usuario (disponible para todos los roles)
    Route::get('/mi-perfil', [PerfilController::class, 'edit'])
        ->name('perfil.edit');

    Route::post('/mi-perfil', [PerfilController::class, 'update'])
        ->name('perfil.update');

    // Boletas de pago (RRHH gestiona todas; cada usuario ve solo las suyas)
    Route::resource('boletas', BoletaController::class)
        ->only(['index', 'store', 'destroy'])
        ->parameters(['boletas' => 'boleta']);

    Route::patch('/reportes/{reporte}/firmar', [ReporteMantenimientoController::class, 'firmarSupervisor'])
        ->name('reportes.firmar');

    // Anomalías (sub-módulo de Mantenimiento: reporte de anomalías en pozos)
    Route::resource('anomalias', AnomaliaController::class)
        ->only(['index', 'store', 'destroy'])
        ->parameters(['anomalias' => 'anomalia']);

    Route::patch('/anomalias/{anomalia}/estado', [AnomaliaController::class, 'updateEstado'])
        ->name('anomalias.update_estado');

    Route::get('/anomalias/{anomalia}', [AnomaliaController::class, 'show'])
        ->name('anomalias.show');

    Route::get('/anomalias/{anomalia}/pdf', [AnomaliaController::class, 'pdf'])
        ->name('anomalias.pdf');

    // Ruta para imprimir PDF de requerimientos
    Route::get('/requerimientos/{id}/pdf', [RequerimientoController::class, 'imprimir'])
    ->name('requerimientos.imprimir');


    Route::resource('requerimientos', RequerimientoController::class);
    

    Route::get('/bienvenida', [DashboardWelcomeController::class, 'index'])
        ->middleware(['auth']) // opcional
        ->name('bienvenida');

    Route::get('/requerimientos/export/excel', [RequerimientoController::class, 'exportExcel'])
    ->name('requerimientos.export.excel');

 
   Route::get('/control_cartas', [ControlCartaController::class, 'index'])->name('control_cartas.index');
   Route::resource('control_cartas', ControlCartaController::class);

    Route::get(
    '/control_cartas/export/excel',
    [ControlCartaController::class, 'exportExcel']
)->name('control_cartas.export.excel');

Route::get(
    '/control_cartas/{id}/export/pdf',
    [ControlCartaController::class, 'exportPdfIndividual']
)->name('control_cartas.export.pdf.individual');

Route::patch('/control_cartas/{id}/estado',
  [ControlCartaController::class, 'updateEstado']
)->name('control_cartas.update_estado');

Route::get(
    '/control_cartas/{id}/historial',
    [ControlCartaController::class, 'historial']
)->name('control_cartas.historial');

Route::resource('cartas_fis', \App\Http\Controllers\CartaFisController::class)
    ->only(['index','store','update','destroy']);


// Rutas de Exportación y Backup
Route::get('/cartas-fis/excel', [CartaFisController::class, 'exportExcel'])->name('cartas_fis.excel');
Route::get('/cartas-fis/backup', [CartaFisController::class, 'backup'])->name('cartas_fis.backup');

// Ruta de recursos (index, store, update, etc.)
Route::resource('cartas_fis', CartaFisController::class);


// ===== Cartas SO-IPF (Ingeniería de Producción y Facilidades) =====
Route::get('/cartas_ipf', [CartaIpfController::class, 'index'])->name('cartas_ipf.index');
Route::resource('cartas_ipf', CartaIpfController::class);

Route::get(
    '/cartas_ipf/export/excel',
    [CartaIpfController::class, 'exportExcel']
)->name('cartas_ipf.export.excel');

Route::get(
    '/cartas_ipf/{id}/export/pdf',
    [CartaIpfController::class, 'exportPdfIndividual']
)->name('cartas_ipf.export.pdf.individual');

Route::patch('/cartas_ipf/{id}/estado',
    [CartaIpfController::class, 'updateEstado']
)->name('cartas_ipf.update_estado');

Route::get(
    '/cartas_ipf/{id}/historial',
    [CartaIpfController::class, 'historial']
)->name('cartas_ipf.historial');

// ===== Cartas SO-MAN (Mantenimiento) =====
Route::get('/cartas_man', [CartaManController::class, 'index'])->name('cartas_man.index');
Route::resource('cartas_man', CartaManController::class);

Route::get(
    '/cartas_man/export/excel',
    [CartaManController::class, 'exportExcel']
)->name('cartas_man.export.excel');

Route::get(
    '/cartas_man/{id}/export/pdf',
    [CartaManController::class, 'exportPdfIndividual']
)->name('cartas_man.export.pdf.individual');

Route::patch('/cartas_man/{id}/estado',
    [CartaManController::class, 'updateEstado']
)->name('cartas_man.update_estado');

Route::get(
    '/cartas_man/{id}/historial',
    [CartaManController::class, 'historial']
)->name('cartas_man.historial');

// ===== Cartas SO-LOG (Logística Almacenes Lote IX) =====
Route::get('/cartas_log', [CartaLogController::class, 'index'])->name('cartas_log.index');
Route::resource('cartas_log', CartaLogController::class);

Route::get(
    '/cartas_log/export/excel',
    [CartaLogController::class, 'exportExcel']
)->name('cartas_log.export.excel');

Route::get(
    '/cartas_log/{id}/export/pdf',
    [CartaLogController::class, 'exportPdfIndividual']
)->name('cartas_log.export.pdf.individual');

Route::patch('/cartas_log/{id}/estado',
    [CartaLogController::class, 'updateEstado']
)->name('cartas_log.update_estado');

Route::get(
    '/cartas_log/{id}/historial',
    [CartaLogController::class, 'historial']
)->name('cartas_log.historial');


Route::resource('logistica_lotes', LogisticaLoteController::class);

Route::get('/logistica-lotes/{id}/pdf', [LogisticaLoteController::class, 'exportPdf'])->name('logistica_lotes.pdf');

Route::post('logistica_lotes/{id}/actualizar-estado', [LogisticaLoteController::class, 'updateEstado'])
    ->name('logistica_lotes.update_estado');

Route::get('/logistica_lotes/{id}/historial', [LogisticaLoteController::class, 'historial'])
    ->name('logistica_lotes.historial');

Route::get('logistica-export', [LogisticaLoteController::class, 'exportExcel'])
    ->name('logistica_lotes.export.excel');







});

// Auth scaffolding (no tocar)
require __DIR__ . '/auth.php';
