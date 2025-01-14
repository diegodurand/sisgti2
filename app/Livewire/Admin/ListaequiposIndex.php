<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Equipoinformatico;
use App\Models\Laboratorio;
use App\Models\Componente;

class ListaequiposIndex extends Component
{
    public function render()
    {
        $equipoinformatico = Equipoinformatico::all();
        $laboratorios = Laboratorio::all();
        $componentes = Componente::all();
        return view('livewire.admin.listaequipos-index',compact('equipoinformatico','laboratorios','componentes'));
    }
}
