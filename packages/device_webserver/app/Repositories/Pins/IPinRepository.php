<?php

namespace App\Repositories\Pins;

use App\Domain\Pins\Pin;

interface IPinRepository
{
    public function exists(int $pin): bool;
    public function getPinByPinNumber(int $pin): Pin;
    public function save(Pin $pin): void;
}
