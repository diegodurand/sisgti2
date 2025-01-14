<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobiliario;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class MobiliarioController extends Controller
{
    // Función para mostrar una lista de mobiliarioes
    public function index()
    {
        return view('admin.mobiliario.index');
    }

    //Función para el reporte
    public function generatePDF()
    {
        $mobiliario = Mobiliario::all();
        $pdf = PDF::loadView('admin.mobiliario.pdf', compact('mobiliario'));
        return $pdf->stream();
    }

    // Función para almacenar una nueva mobiliario en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'nombre' => 'required',
            'descripcion' => 'required',
            'cantidad' => 'required',
            'codigo' => 'required',
            'laboratorio_id' => 'nullable',	
        ]);

        $mobiliario = new Mobiliario();

        $mobiliario->nombre = $validatedData['nombre'];
        $mobiliario->descripcion = $validatedData['descripcion'];
        $mobiliario->cantidad = $validatedData['cantidad'];
        $mobiliario->codigo = $validatedData['codigo'];
        $mobiliario->laboratorio_id = $validatedData['laboratorio_id']; 

        // Generar código de barras
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($mobiliario->codigo, $generator::TYPE_CODE_128);
    
        // Guardar el código de barras como archivo
        $barcodePath = public_path('barcodes/' . $mobiliario->codigo . '.png');
        file_put_contents($barcodePath, $barcode);

        $mobiliario->save();    


        if($mobiliario){
            return redirect()->route('admin.mobiliario.index')->with('success', 'mobiliario creado correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al crear la mobiliario.' . $mobiliario->getMessage());
        }
    }

    // Función para actualizar los datos de una mobiliario en la base de datos
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            
            'nombre' => 'required',
            'descripcion' => 'required',
            'cantidad' => 'required',
            'laboratorio_id' => 'nullable',
        ]);

        $mobiliario = Mobiliario::findOrFail($id);

        $mobiliario->nombre = $validatedData['nombre'];
        $mobiliario->descripcion = $validatedData['descripcion'];
        $mobiliario->cantidad = $validatedData['cantidad'];
        $mobiliario->laboratorio_id = $validatedData['laboratorio_id']; 

        $mobiliario->save();    


        if($mobiliario){
            return redirect()->route('admin.mobiliario.index')->with('success', 'mobiliario actualizado correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al actualizar la mobiliario.' . $mobiliario->getMessage());
        }
    }

    // Función para eliminar una mobiliario de la base de datos
    public function destroy(string $id)
    {
        Mobiliario::find($id)->delete();
        return redirect()->route('admin.mobiliario.index')->with('success', 'mobiliario eliminado correctamente.');
    }
}