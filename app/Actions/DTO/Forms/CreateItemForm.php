<?php

namespace App\Actions\DTO\Forms;

use App\Actions\Contracts\RequestForm;
use Illuminate\Http\Request;

class CreateItemForm implements RequestForm
{
    public static function fromRequest(Request $request): self
    {
        return new self();
    }
}
