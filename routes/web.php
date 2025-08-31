<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteMantenimientoController;
use App\Http\Controllers\InspeccionVehicularController;
use App\Http\Controllers\RequerimientoController;

// Redirect al login por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Área autenticada
Route::middleware(['auth'])->group(function () {

    // Dashboard (si tu dashboard muestra los reportes existentes)
    Route::get('/dashboard', [ReporteMantenimientoController::class, 'index'])
        ->name('dashboard');

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

});

// Auth scaffolding (no tocar)
require __DIR__ . '/auth.php';
