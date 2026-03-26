<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $fillable = ['nombre', 'sede_id'];

    // La carrera ahora pertenece a una Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function especializaciones()
    {
        return $this->hasMany(Especializacion::class, 'carrera_id');
    }
}
