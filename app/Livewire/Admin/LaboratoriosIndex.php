<?php

namespace App\Livewire\Admin;


use App\Models\Laboratorio;
use Livewire\Component;

class LaboratoriosIndex extends Component
{
    public function render()
    {

        $laboratorios = Laboratorio::all();
        return view('livewire.admin.laboratorios-index', compact('laboratorios'));
    }
}