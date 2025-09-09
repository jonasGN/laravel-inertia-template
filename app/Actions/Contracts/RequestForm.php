<?php

namespace App\Actions\Contracts;

use Illuminate\Http\Request;

interface RequestForm
{
    /**
     * Retorna uma instância parseada da requisição
     */
    public static function fromRequest(Request $request): self;
}
