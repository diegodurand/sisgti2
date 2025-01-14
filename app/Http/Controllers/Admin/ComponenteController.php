<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Componente;
use App\Models\EquipoInformatico;
use Barryvdh\DomPDF\Facade\Pdf;

class ComponenteController extends Controller
{


    //Función para el reporte
    public function generatePDF()
    {
        $equipoinformatico = Equipoinformatico::all();
        $pdf = PDF::loadView('admin.componente.pdf', compact('equipoinformatico'));
        return $pdf->stream();
    }


    public function store(Request $request)
{
    $equipoinformatico_id = $request->input('equipoinformatico_id');
    $componentes = $request->input('componentes');

    try {
        foreach ($componentes as $componente) {
            $nuevoComponente = new Componente();
            $nuevoComponente->tipo = $componente['tipo'];
            $nuevoComponente->descripcion = $componente['descripcion'];
            $nuevoComponente->marca = $componente['marca'];
            $nuevoComponente->modelo = $componente['modelo'];
            $nuevoComponente->numeroserie = $componente['numeroserie'];
            $nuevoComponente->equipo_id = $equipoinformatico_id;
            $nuevoComponente->save();
        }

        return redirect()->route('admin.equipoinformatico.index')->with('success', 'Componentes agregados con éxito');
    } catch (\Exception $e) {
        return redirect()->route('admin.equipoinformatico.index')->with('error', 'Ocurrió un error al registrar los componentes: ' . $e->getMessage());
    }
}

    

        public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'componentes.*.tipo' => 'required',
            'componentes.*.descripcion' => 'required',
            'componentes.*.marca' => 'required',
            'componentes.*.modelo' => 'required',
            'componentes.*.numeroserie' => 'required',
        ]);

        foreach ($request->componentes as $componenteId => $componenteData) {
            $componente = Componente::findOrFail($componenteId);
            $componente->tipo = $componenteData['tipo'];
            $componente->descripcion = $componenteData['descripcion'];
            $componente->marca = $componenteData['marca'];
            $componente->modelo = $componenteData['modelo'];
            $componente->numeroserie = $componenteData['numeroserie'];
            $componente->save();
        }

        return redirect()->route('admin.equipoinformatico.index')->with('success', 'Componentes actualizados correctamente.');
    }
 

}
