<?php

namespace App\Repositories\MainServer;

use App\Core\Result;
use App\Domain\Pins\Pin;

interface IMainServerRepository
{
    /**
     * @return Result<void>
     */
    public function checkIn(Pin $pin): Result;
}
