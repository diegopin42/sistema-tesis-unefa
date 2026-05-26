<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['nombre', 'apellidos', 'cedula', 'rol'];

   
    public function tesisComoAutor()
    {
        return $this->hasMany(Tesis::class, 'autor_id');
    }

    public function tesisComoTutor()
    {
        return $this->hasMany(Tesis::class, 'tutor_id');
    }
}