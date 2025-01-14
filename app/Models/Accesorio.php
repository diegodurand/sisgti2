<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'marca',
        'modelo',
        'codigo',
        'numero_serie',
        'laboratorio_id',
    ];

    // Relación con Laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }
}