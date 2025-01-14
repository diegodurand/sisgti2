<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laboratorio;

class LaboratorioController extends Controller
{
    // Función para mostrar una lista de laboratorioes
    public function index()
    {
        return view('admin.laboratorio.index');
    }

    // Función para almacenar una nueva laboratorio en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'nombre' => 'required',
        ]);

        $laboratorio = new Laboratorio();

        $laboratorio->nombre = $validatedData['nombre'];

        $laboratorio->save();    


        if($laboratorio){
            return redirect()->route('admin.laboratorio.index')->with('success', 'laboratorio creada correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al crear la laboratorio.' . $laboratorio->getMessage());
        }
    }

    // Función para actualizar los datos de una laboratorio en la base de datos
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            
            'nombre' => 'required',
        ]);

        $laboratorio = Laboratorio::findOrFail($id);

        $laboratorio->nombre = $validatedData['nombre'];

        $laboratorio->save();    


        if($laboratorio){
            return redirect()->route('admin.laboratorio.index')->with('success', 'laboratorio actualizada correctamente.');
        } else{
            return redirect()->back()->withErrors('Error al actualizar la laboratorio.' . $laboratorio->getMessage());
        }
    }

    // Función para eliminar una laboratorio de la base de datos
    public function destroy(string $id)
    {
        Laboratorio::find($id)->delete();
        return redirect()->route('admin.laboratorio.index')->with('success', 'laboratorio eliminada correctamente.');
    }
}