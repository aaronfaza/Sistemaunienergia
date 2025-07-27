<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteMantenimientoController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [ReporteMantenimientoController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::resource('reportes', ReporteMantenimientoController::class);
Route::get('/reportes/{id}', [ReporteMantenimientoController::class, 'show'])->name('reportes.show');
Route::get('/reportes/{id}/pdf', [ReporteMantenimientoController::class, 'pdf'])->name('reportes.pdf');
Route::post('/reportes', [ReporteMantenimientoController::class, 'store'])->name('reportes.store');

require __DIR__.'/auth.php';