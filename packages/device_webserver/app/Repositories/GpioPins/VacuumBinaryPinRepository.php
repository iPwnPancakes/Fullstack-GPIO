<?php

namespace App\Repositories\GpioPins;

use App\Domain\Pins\Pin;
use Exception;

class VacuumBinaryPinRepository implements IGpioPinRepository
{
    public function exists(int $pin): bool
    {
        throw new Exception('Not implemented');
    }

    public function getPinByPinNumber(int $pin): Pin
    {
        throw new Exception('Not implemented');
    }

    public function save(Pin $pin): void
    {
        throw new Exception('Not implemented');
    }
}
