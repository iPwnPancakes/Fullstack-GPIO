<?php

namespace App\Repositories\GpioPins;

use App\Domain\Pins\Pin;

interface IGpioPinRepository
{
    public function exists(int $pin): bool;
    public function getPinByPinNumber(int $pin): Pin;
    public function save(Pin $pin): void;
}
