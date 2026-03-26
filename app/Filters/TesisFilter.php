<?php

namespace App\Filters;

class TesisFilter extends ApiFilter
{
    // Parámetros permitidos y sus operadores
    protected $safeParams = [
        'titulo' => ['eq', 'lk'],      
        'estado' => ['eq'],            
        'autorId' => ['eq'],           
        'tutorId' => ['eq'],           
        'especializacionId' => ['eq'],
    ];

    // Mapeo de nombres de la URL a nombres de la Base de Datos
    protected $columnMap = [
        'autorId' => 'autor_id',
        'tutorId' => 'tutor_id',
        'especializacionId' => 'especializacion_id',
    ];

    // Mapeo de operadores lógicos
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'lk' => 'like',
    ];
}