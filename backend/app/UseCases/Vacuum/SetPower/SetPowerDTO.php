<?php

namespace App\UseCases\Vacuum\SetPower;

use App\Core\Request;

class SetPowerDTO extends Request
{
    public $vacuum_id;
    public $power_state;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
