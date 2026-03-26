<?php

namespace App\Filters;

class PersonaFilter extends ApiFilter
{
    // Parámetros permitidos en la URL
    protected $safeParams = [
        'nombre' => ['eq', 'lk'], 
        'apellidos' => ['eq', 'lk'], 
        'cedula' => ['eq'], 
        'rol' => ['eq'], 
    ];


    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like',
    ];
}