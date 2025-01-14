<?php

namespace App\Livewire\Admin;

use App\Models\Accesorio;
use App\Models\Equipoinformatico;
use App\Models\Laboratorio;
use App\Models\Mobiliario;
use Livewire\Component;

class HomeIndex extends Component
{
    public function render()
    {  
        $equiposinformaticos=Equipoinformatico::count();
        $accesorios=Accesorio::count();
        $mobiliarios=Mobiliario::count();
        $laboratorios=Laboratorio::count();
        return view('livewire.admin.home-index',compact('equiposinformaticos','accesorios','mobiliarios','laboratorios'));
    }
}