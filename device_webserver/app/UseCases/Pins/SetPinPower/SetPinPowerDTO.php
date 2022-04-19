<?php

namespace App\UseCases\Pins\SetPinPower;

use App\Core\Request;

class SetPinPowerDTO extends Request
{
    public $pin_number;
    public $pin_power_state;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
