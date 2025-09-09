<?php

namespace App\Actions\DTO\Results;

use App\Actions\Contracts\QueryResult;

class ItemResult implements QueryResult
{
    public static function fromResult(mixed $result): self
    {
        return new self();
    }
}
