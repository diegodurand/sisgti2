<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Equipoinformatico extends Model
{
    use HasFactory;
    protected $fillable = [
        'marca',
        'modelo',
        'estado',
        'valor', 
        'codigo',
        'laboratorio_id',
    ];

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }
    
    public function componentes()
    {
        return $this->hasMany(Componente::class, 'equipo_id');
    }
}
