<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';
    protected $fillable = ['nombre'];

    // Ahora la Sede tiene muchas carreras directamente
    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'sede_id');
    }
}
