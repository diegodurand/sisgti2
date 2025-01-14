<?php

namespace App\Livewire\Admin;

use App\Models\Laboratorio;
use App\Models\Accesorio;
use Livewire\Component;

class AccesoriosIndex extends Component
{
    public function render()
    {
        $accesorios = Accesorio::all();
        $laboratorios = Laboratorio::all();
        return view('livewire.admin.accesorios-index', compact('accesorios','laboratorios'));
    }
}