<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accesorio;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class AccesorioController extends Controller
{
    // Función para mostrar una lista de accesorioes
    public function index()
    {
        return view('admin.accesorio.index');
    }

    //Función para el reporte
    public function generatePDF()
    {
        $accesorio = Accesorio::all();
        $pdf = PDF::loadView('admin.accesorio.pdf', compact('accesorio'));
        return $pdf->stream();
    }

    // Función para almacenar una nueva accesorio en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'codigo' => 'required',
            'numero_serie' => 'required',
            'laboratorio_id' => 'nullable',
        ]);
    
        $accesorio = new Accesorio();
    
        $accesorio->nombre = $validatedData['nombre'];
        $accesorio->descripcion = $validatedData['descripcion'];
        $accesorio->marca = $validatedData['marca'];
        $accesorio->modelo = $validatedData['modelo'];
        $accesorio->codigo = $validatedData['codigo'];
        $accesorio->numero_serie = $validatedData['numero_serie'];
        $accesorio->laboratorio_id = $validatedData['laboratorio_id']; 
    
        $accesorio->save();    
    
        // Generar código de barras
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($accesorio->codigo, $generator::TYPE_CODE_128);
    
        // Guardar el código de barras como archivo
        $barcodePath = public_path('barcodes/' . $accesorio->codigo . '.png');
        file_put_contents($barcodePath, $barcode);
    
        $accesorio->save();
    
        if($accesorio){
            return redirect()->route('admin.accesorio.index')->with('success', 'accesorio creado correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al crear la accesorio.' . $accesorio->getMessage());
        }
    }

    // Función para actualizar los datos de una accesorio en la base de datos
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            
            'nombre' => 'required',
            'descripcion' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'numero_serie' => 'required',
            'laboratorio_id' => 'nullable',
        ]);

        $accesorio = Accesorio::findOrFail($id);

        $accesorio->nombre = $validatedData['nombre'];
        $accesorio->descripcion = $validatedData['descripcion'];
        $accesorio->marca = $validatedData['marca'];
        $accesorio->modelo = $validatedData['modelo'];
        $accesorio->numero_serie = $validatedData['numero_serie'];
        $accesorio->laboratorio_id = $validatedData['laboratorio_id']; 

        $accesorio->save();    


        if($accesorio){
            return redirect()->route('admin.accesorio.index')->with('success', 'accesorio actualizado correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al actualizar la accesorio.' . $accesorio->getMessage());
        }
    }

    // Función para eliminar una accesorio de la base de datos
    public function destroy(string $id)
    {
        Accesorio::find($id)->delete();
        return redirect()->route('admin.accesorio.index')->with('success', 'accesorio eliminado correctamente.');
    }
}