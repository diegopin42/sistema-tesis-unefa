<?php

namespace App\Filters;

class EspecializacionFilter extends ApiFilter
{
    protected $safeParams = [
        'nombre' => ['eq', 'lk'],
        'carreraId' => ['eq'], // Para filtrar especializaciones de una carrera específica
    ];

    protected $columnMap = [
        'carreraId' => 'carrera_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like',
    ];
}