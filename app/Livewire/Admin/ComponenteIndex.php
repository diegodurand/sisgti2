<?php

namespace App\Livewire\Admin;

use App\Models\Componente;
use Livewire\Component;

class ComponenteIndex extends Component
{
    public function render()
    {
        $componente = Componente::all();
        return view('livewire.admin.componente-index',compact('componente'));
    }

}
