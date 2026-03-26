<?php

namespace App\Filters;

class SedeFilter extends ApiFilter
{
    // Parámetros permitidos: nombre exacto o parcial (like)
    protected $safeParams = [
        'nombre' => ['eq', 'lk'],
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like',
    ];
}