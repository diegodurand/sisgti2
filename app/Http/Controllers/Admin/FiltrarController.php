<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipoInformatico;
use App\Models\Laboratorio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FiltrarController extends Controller
{
    public function procesarFormulario(Request $request)
    {
        // Recibe el laboratorio seleccionado del formulario
        $laboratorioId = $request->input('laboratorio', null);

        // Asegurarse de que el laboratorio no esté vacío
        if (empty($laboratorioId)) {
            return redirect()->back()->with('error', 'No se seleccionó un laboratorio.');
        }

        // Aplica el filtro por laboratorio a la consulta
        $equiposInformaticos = EquipoInformatico::where('laboratorio_id', $laboratorioId)->get();

        // Crea el PDF con Dom PDF
        $pdf = PDF::loadView('admin.report.filtro-reportes', ['equiposInformaticos' => $equiposInformaticos]);
        return $pdf->stream();
    }

    public function index()
    {
        return view('admin.filtrar.index');
    }
}