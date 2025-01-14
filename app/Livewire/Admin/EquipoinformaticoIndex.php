<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Equipoinformatico;
use App\Models\Laboratorio;
use App\Models\Componente;
class EquipoinformaticoIndex extends Component
{
    
    public function render()
    {
        $equipoinformatico = Equipoinformatico::all();
        $laboratorios = Laboratorio::all();
        $componentes = Componente::all();
        return view('livewire.admin.equipoinformatico-index',compact('equipoinformatico','laboratorios','componentes'));
    }
}
