<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipoinformatico;
use App\Models\Accesorio;
use App\Models\Mobiliario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaboReporteController extends Controller
{
    public function generarReporte(Request $request)
    {
        // Validar los laboratorios y el estado seleccionados
        $request->validate([
            'laboratorios' => 'required|array',
            'laboratorios.*' => 'exists:laboratorios,id',
            'estado' => 'nullable|string|in:Disponible,En uso,En mantenimiento', // Validar el estado, si es proporcionado
        ]);
    
        // Obtener los equipos filtrados por laboratorios seleccionados
        $equipos = Equipoinformatico::whereIn('laboratorio_id', $request->laboratorios);
    
        // Si se ha seleccionado un estado, agregar el filtro de estado
        if ($request->filled('estado')) {
            $equipos->where('estado', $request->estado);
        }
    
        // Obtener los resultados finales
        $equipos = $equipos->get();
    
        // Generar el PDF con la vista 'reporte.equipos' y pasar los equipos
        $pdf = PDF::loadView('reporte.equipos', compact('equipos'));
    
        // Devolver el PDF para ser descargado o visualizado en el navegador
        return $pdf->stream('reporte_equipos.pdf'); // o ->download('reporte_equipos.pdf') para descargar directamente
    }

    public function generarReportecomponentes(Request $request)
    {
        // Validar los laboratorios y el estado seleccionados
        $request->validate([
            'laboratorios' => 'required|array',
            'laboratorios.*' => 'exists:laboratorios,id',
            'estado' => 'nullable|string|in:Disponible,En uso,En mantenimiento', // Validar el estado, si es proporcionado
        ]);
    
        // Obtener los equipos filtrados por laboratorios seleccionados
        $equipos = Equipoinformatico::whereIn('laboratorio_id', $request->laboratorios);
    
        // Si se ha seleccionado un estado, agregar el filtro de estado
        if ($request->filled('estado')) {
            $equipos->where('estado', $request->estado);
        }
    
        // Obtener los resultados finales
        $equipos = $equipos->get();
    
        // Generar el PDF con la vista 'reporte.equiposaccesorios' y pasar los equipos
        $pdf = PDF::loadView('reporte.equiposcomponentes', compact('equipos'));
    
        // Devolver el PDF para ser descargado o visualizado en el navegador
        return $pdf->stream('reporte_componentes.pdf'); // Cambia el nombre del archivo si es necesario
    }

    public function generarReporteAccesorios(Request $request)
    {
        // Validar los laboratorios seleccionados
        $request->validate([
            'laboratorios' => 'required|array',
            'laboratorios.*' => 'exists:laboratorios,id',
        ]);
    
        // Obtener los accesorios filtrados por laboratorios seleccionados
        $accesorios = Accesorio::whereIn('laboratorio_id', $request->laboratorios)->get();
    
        // Generar el PDF con la vista 'reporte.accesorios' y pasar los accesorios
        $pdf = PDF::loadView('reporte.accesorios', compact('accesorios'))->setPaper('a4', 'landscape');    
        // Devolver el PDF para ser descargado o visualizado en el navegador
        return $pdf->stream('reporte_accesorios.pdf'); // Cambia el nombre del archivo si es necesario
    }

    public function generarReporteMobiliario(Request $request)
    {
        // Validar los laboratorios seleccionados
        $request->validate([
            'laboratorios' => 'required|array',
            'laboratorios.*' => 'exists:laboratorios,id',
        ]);
    
        // Obtener los Mobiliario filtrados por laboratorios seleccionados
        $mobiliarios = Mobiliario::whereIn('laboratorio_id', $request->laboratorios)->get();
    
        // Generar el PDF con la vista 'reporte.accesorios' y pasar los accesorios
        $pdf = PDF::loadView('reporte.mobiliarios', compact('mobiliarios'));    
        // Devolver el PDF para ser descargado o visualizado en el navegador
        return $pdf->stream('reporte_mobiliarios.pdf'); // Cambia el nombre del archivo si es necesario
    }
    
}
