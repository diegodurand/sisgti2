<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobiliario extends Model
{
    use HasFactory;

    protected $fillable = [

        'nombre',
        'descripcion',
        'cantidad', 
        'codigo',
    ];
  // Relación con Laboratorio
  public function laboratorio()
  {
      return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
  }
}