<?php

namespace App\Livewire\Admin;

use App\Models\Laboratorio;
use App\Models\Mobiliario;
use Livewire\Component;

class MobiliariosIndex extends Component
{
    public function render()
    {
        $mobiliarios = Mobiliario::all();
        $laboratorios = Laboratorio::all();
        return view('livewire.admin.mobiliarios-index', compact('mobiliarios','laboratorios'));
    }
}