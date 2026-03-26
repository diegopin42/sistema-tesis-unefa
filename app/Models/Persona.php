<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['nombre', 'apellidos', 'cedula', 'rol'];

    // Tesis donde esta persona es el autor
    public function tesisComoAutor()
    {
        return $this->hasMany(Tesis::class, 'autor_id');
    }

    // Tesis donde esta persona es el tutor
    public function tesisComoTutor()
    {
        return $this->hasMany(Tesis::class, 'tutor_id');
    }
}