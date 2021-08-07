<?php

namespace App\Repositories\Pins;

use App\Domain\Pins\Pin;

interface IPinRepository
{
    public function exists(int $pin_number): bool;
    public function getPinByPinNumber(int $pin_number): Pin;
    public function save(Pin $newPinState): void;
}
