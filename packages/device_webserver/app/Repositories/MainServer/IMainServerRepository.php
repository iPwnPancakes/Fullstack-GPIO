<?php

namespace App\Repositories\MainServer;

use App\Core\Result;

interface IMainServerRepository
{
    /**
     * @return Result<void>
     */
    public function checkIn(): Result;
}
