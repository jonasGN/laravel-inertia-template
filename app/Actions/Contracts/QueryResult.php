<?php

namespace App\Actions\Contracts;

interface QueryResult
{
    /**
     * Retorna uma instância baseada nos resultados vindos de uma consulta ao banco de dados
     */
    public static function fromResult(mixed $result): self;
}
