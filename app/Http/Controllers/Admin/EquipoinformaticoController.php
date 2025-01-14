<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipoInformatico;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;


class EquipoinformaticoController extends Controller
{


    public function index()
    {
        return view('admin.equipoinformatico.index');
    }

    //Función para el reporte
    public function generatePDF()
    {
        $equipoinformatico = Equipoinformatico::all();
        $pdf = PDF::loadView('admin.equipoinformatico.pdf', compact('equipoinformatico'));
        return $pdf->stream();
    }
     
    public function generatePDFequipos()
    {
        $equipoinformatico = Equipoinformatico::all();
        $pdf = PDF::loadView('admin.equipoinformatico.pdfequipos', compact('equipoinformatico'));
        return $pdf->stream();
    }


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'estado' => 'required',
            'valor' => 'required', 
            'codigo' => 'required',
            'laboratorio_id' => 'required',
        ]);
    
        // Iniciar una transacción
        DB::transaction(function () use ($validatedData) {
            // Crear el equipo informático
            $equipo = EquipoInformatico::create([
                'marca' => $validatedData['marca'],
                'modelo' => $validatedData['modelo'],
                'estado' => $validatedData['estado'],
                'valor' => $validatedData['valor'] ?? 0,
                'codigo' => $validatedData['codigo'],
                'laboratorio_id' => $validatedData['laboratorio_id'],
            ]);
    
            // Generar el código de barras
            $generator = new BarcodeGeneratorPNG();
            $barcode = $generator->getBarcode($equipo->codigo, $generator::TYPE_CODE_128);
    
            // Guardar el código de barras como archivo
            file_put_contents(public_path('barcodes/' . $equipo->codigo . '.png'), $barcode);
        });
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.equipoinformatico.index')->with('success', 'Equipo registrado correctamente y código de barras generado.');
    }
    
    
     ///Funcion tal vez funciones
    public function showComponentes($id)
        {
            $equiposinformaticos = EquipoInformatico::findOrFail($id);
            $componentes = $equiposinformaticos->componentes; // Asegúrate de que la relación esté definida

            return view('admin.equipoinformatico.componentes');
        }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'estado' => 'required',
            'valor' => 'required',
            'laboratorio_id' => 'required',
        ]);

        $equiposinformaticos = EquipoInformatico::findOrFail($id);

        $equiposinformaticos->marca = $validatedData['marca'];
        $equiposinformaticos->modelo = $validatedData['modelo'];
        $equiposinformaticos->estado = $validatedData['estado'];
        $equiposinformaticos->valor = $validatedData['valor'];
        $equiposinformaticos->laboratorio_id = $validatedData['laboratorio_id'];

        $equiposinformaticos->save();

        return redirect()->route('admin.equipoinformatico.index')->with('success', 'Equipo fue actualizado correctamente.');
    }

    
    public function updateComponentes(Request $request, $id)
    {
        // Encuentra el equipo informático
        $equipoinformatico = EquipoInformatico::findOrFail($id);
    
        // Valida los datos
        $validatedData = $request->validate([
            'componentes.*.tipo' => 'required|string|max:255',
            'componentes.*.descripcion' => 'nullable|string|max:255',
            'componentes.*.marca' => 'nullable|string|max:255',
            'componentes.*.modelo' => 'nullable|string|max:255',
            'componentes.*.numeroserie' => 'nullable|string|max:255',
        ]);
    
        // Itera sobre los componentes y actualiza
        foreach ($request->input('componentes') as $componenteId => $data) {
            $componente = $equipoinformatico->componentes->find($componenteId);
            if ($componente) {
                $componente->update($data);
            }
        }
    
        return redirect()->back()->with('success', 'Componentes actualizados exitosamente.');
    }

    public function destroy(string $id)
    {
        EquipoInformatico::find($id)->delete();
        return redirect()->route('admin.equipoinformatico.index')->with('success', 'El EQUIPO fue eliminado correctamente.');
    }
}
