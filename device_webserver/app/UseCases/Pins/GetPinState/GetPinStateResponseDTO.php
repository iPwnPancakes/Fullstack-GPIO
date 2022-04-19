<?php

namespace App\UseCases\Pins\GetPinState;

use App\Core\Response;

class GetPinStateResponseDTO extends Response
{
    /** @var int */
    public $pin_number;

    /** @var bool */
    public $power_state;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
