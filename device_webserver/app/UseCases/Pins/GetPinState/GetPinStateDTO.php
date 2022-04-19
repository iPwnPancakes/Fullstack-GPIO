<?php

namespace App\UseCases\Pins\GetPinState;

use App\Core\Request;

class GetPinStateDTO extends Request
{
    public $pin_number;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
