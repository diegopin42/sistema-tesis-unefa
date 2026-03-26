<?php

namespace App\Filters;

class CarreraFilter extends ApiFilter
{
    // Parámetros permitidos en la URL
    protected $safeParams = [
        'nombre' => ['eq', 'lk'], 
        'sedeId' => ['eq'],       
    ];

    // Mapeo de la URL a la Base de Datos
    protected $columnMap = [
        'sedeId' => 'sede_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like',
    ];
}