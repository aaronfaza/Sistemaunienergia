<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteMantenimientoController;
use App\Http\Controllers\InspeccionVehicularController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\DashboardWelcomeController;
use App\Http\Controllers\ControlCartaController;
use App\Http\Controllers\CartaFisController;

// Redirect al login por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Área autenticada
Route::middleware(['auth'])->group(function () {

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

    // Ruta para imprimir PDF de requerimientos
    Route::get('/requerimientos/{id}/pdf', [RequerimientoController::class, 'imprimir'])
    ->name('requerimientos.imprimir');
    

    // Inspección vehicular (nuevo caso de uso)
    Route::resource('inspecciones', InspeccionVehicularController::class)
        ->parameters(['inspecciones' => 'inspeccione']); // para el model binding

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

Route::resource('cartas_fis', \App\Http\Controllers\CartaFisController::class)
    ->only(['index','store','update','destroy']);









});

// Auth scaffolding (no tocar)
require __DIR__ . '/auth.php';
