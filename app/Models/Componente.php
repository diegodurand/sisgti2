<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',
        'descripcion',
        'marca',
        'modelo',
        'numeroserie',
        // 'equipo_id',
    ]; //relacion uno a muchos inversa
    public function equipo()
    {
        return $this->belongsTo(Equipoinformatico::class,'equipo_id');
    }
}
