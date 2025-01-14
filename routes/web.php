<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\EquipoinformaticoController;
use App\Http\Controllers\Admin\ComponenteController;
use App\Http\Controllers\Admin\AccesorioController;
use App\Http\Controllers\Admin\MobiliarioController;
use App\Http\Controllers\Admin\LaboratorioController;
use App\Http\Controllers\Admin\FiltrarController;
use App\Http\Controllers\Admin\LaboReporteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;
Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home.index');
    //Rutas para Laboratories
    Route::get('laboratorio', [LaboratorioController::class, 'index'])->name('laboratorio.index');
    Route::post('laboratorio', [LaboratorioController::class, 'store'])->name('laboratorio.store');
    Route::put('laboratorio/{id}', [LaboratorioController::class, 'update'])->name('laboratorio.update');
    Route::delete('laboratorio/{id}', [LaboratorioController::class, 'destroy'])->name('laboratorio.destroy');

    //rutas para Pcs
    Route::get('equipoinformatico', [EquipoinformaticoController::class, 'index'])->name('equipoinformatico.index');
    Route::post('equipoinformatico', [EquipoinformaticoController::class, 'store'])->name('equipoinformatico.store');
    Route::delete('equipoinformatico/{id}', [EquipoinformaticoController::class, 'destroy'])->name('equipoinformatico.destroy');
    Route::put('equipoinformatico/{id}', [EquipoinformaticoController::class, 'update'])->name('equipoinformatico.update');
    Route::get('equipoinformatico/{id}/componentes', [EquipoinformaticoController::class, 'showComponentes'])->name('equipoinformatico.showComponentes');
    Route::put('equipoinformatico/{id}/componentes', [EquipoInformaticoController::class, 'updateComponentes'])->name('equipoinformatico.updateComponentes');
    Route::put('componente/{id}', [ComponenteController::class, 'update'])->name('componente.update');
    Route::post('componente', [ComponenteController::class, 'store'])->name('componente.store');
    Route::get('componentes/{id}/report', 'ComponenteController@generateComponenteReport')->name('componentes.report');
    Route::get('/equipoinformatico/pdf', [EquipoinformaticoController::class, 'generatePDF'])->name('equipoinformatico.pdf');
    Route::get('/equipoinformatico/pdfequipos', [EquipoinformaticoController::class, 'generatePDFequipos'])->name('equipoinformatico.pdfequipos');
    Route::get('/barcode/html/{codigo}', [EquipoinformaticoController::class, 'generateHTML'])->name('barcode.html');
    Route::get('/barcode/png/{codigo}', [EquipoinformaticoController::class, 'generatePNG'])->name('barcode.png');
    Route::get('/componente/pdf', [ComponenteController::class, 'generatePDF'])->name('componente.pdf');
    // Ruta para mostrar el formulario de filtrado
    Route::get('/filtrar', [FiltrarController::class, 'index'])->name('filtro.index');

    // Ruta para procesar el formulario de filtrado y generar el PDF
    Route::post('/filtrar', [FiltrarController::class, 'procesarFormulario'])->name('filtro.buscar');

    //Rutas para Accesorio

    Route::get('accesorio', [AccesorioController::class, 'index'])->name('accesorio.index');
    Route::post('accesorio', [AccesorioController::class, 'store'])->name('accesorio.store');
    Route::put('accesorio/{id}', [AccesorioController::class, 'update'])->name('accesorio.update');
    Route::delete('accesorio/{id}', [AccesorioController::class, 'destroy'])->name('accesorio.destroy');
    Route::get('/accesorio/pdf', [AccesorioController::class, 'generatePDF'])->name('accesorio.pdf');

   //Rutas para Mobiliario

   Route::get('mobiliario', [MobiliarioController::class, 'index'])->name('mobiliario.index');
   Route::post('mobiliario', [MobiliarioController::class, 'store'])->name('mobiliario.store');
   Route::put('mobiliario/{id}', [MobiliarioController::class, 'update'])->name('mobiliario.update');
   Route::delete('mobiliario/{id}', [MobiliarioController::class, 'destroy'])->name('mobiliario.destroy');
   Route::get('/mobiliario/pdf', [MobiliarioController::class, 'generatePDF'])->name('mobiliario.pdf');

   //ruta para el reporte de laboratorio
   Route::post('/reporte-equipos', [LaboReporteController::class, 'generarReporte'])->name('reporte.equipos');
   Route::post('/reporte-equiposcomponentes', [LaboReporteController::class, 'generarReportecomponentes'])->name('reporte.equiposcomponentes');
   Route::post('/reporte-accesorios', [LaboReporteController::class, 'generarReporteAccesorios'])->name('reporte.accesorios');
   Route::post('/reporte-mobiliarios', [LaboReporteController::class, 'generarReporteMobiliario'])->name('reporte.mobiliarios');    

});

require __DIR__.'/auth.php';
