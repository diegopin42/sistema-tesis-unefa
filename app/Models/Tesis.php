<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    protected $table = 'tesis'; // El plural de tesis es tesis
    protected $fillable = [
        'titulo', 
        'especializacion_id', 
        'autor_id', 
        'tutor_id', 
        'ruta_pdf', 
        'estado', 
        'fecha_presentacion'
    ];

    public function especializacion()
    {
        return $this->belongsTo(Especializacion::class, 'especializacion_id');
    }

    public function autor()
    {
        return $this->belongsTo(Persona::class, 'autor_id');
    }

    public function tutor()
    {
        return $this->belongsTo(Persona::class, 'tutor_id');
    }
}
