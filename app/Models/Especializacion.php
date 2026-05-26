<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especializacion extends Model
{
    protected $table = 'especializaciones'; // Plural complejo para Laravel
    protected $fillable = ['nombre', 'carrera_id'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function tesis()
    {
        return $this->hasMany(Tesis::class, 'especializacion_id');
    }
}
