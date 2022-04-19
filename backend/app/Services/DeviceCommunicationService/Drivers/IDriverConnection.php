<?php

namespace App\Services\DeviceCommunicationService\Drivers;

use App\Core\Result;
use App\Models\Vacuum;

interface IDriverConnection
{
    public function __construct(Vacuum $vacuum);
    public function ping(): Result;
    public function setPower(bool $power): Result;

    /**
     * @return Result<bool>
     */
    public function getPower(): Result;
}
