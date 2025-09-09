<?php

namespace App\Actions\Commands;

use App\Actions\DTO\Forms\CreateItemForm;
use App\Actions\DTO\Results\ItemResult;

/**
 * Exemplo de uma Action Command
 */
final class CreateItem
{
    public function handle(CreateItemForm $form): ItemResult
    {
        return new ItemResult();
    }
}
