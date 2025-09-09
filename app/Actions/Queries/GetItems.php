<?php

namespace App\Actions\Queries;

use App\Actions\DTO\Results\ItemResult;
use Illuminate\Support\Collection;

/**
 * Exemplo de uma Action Query
 */
final class GetItems
{
    /**
     * @return Collection<ItemResult>
     */
    public function handle(): Collection
    {
        return Collection::make([new ItemResult()]);
    }
}
