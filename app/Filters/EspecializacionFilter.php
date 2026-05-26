<?php

namespace App\Filters;

class EspecializacionFilter extends ApiFilter
{
    protected $safeParams = [
        'nombre' => ['eq', 'lk'],
        'carreraId' => ['eq'],
        'tipo' => ['eq'],
    ];

    protected $columnMap = [
        'carreraId' => 'carrera_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like',
    ];
}