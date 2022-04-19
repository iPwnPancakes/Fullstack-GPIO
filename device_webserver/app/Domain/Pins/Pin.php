<?php

namespace App\Domain\Pins;

use App\Core\Result;

class Pin
{
    public $number;
    public $power;

    private function __construct(int $pin_number, bool $power_state)
    {
        $this->number = $pin_number;
        $this->power = $power_state;
    }

    public static function create(int $pin_number, bool $power_state): Result
    {
        return Result::ok(new Pin($pin_number, $power_state));
    }

    public function getPinNumber()
    {
        return $this->number;
    }

    public function getPowerState()
    {
        return $this->power;
    }

    public function setPowerState(bool $powerState)
    {
        $this->power = $powerState;
    }
}
