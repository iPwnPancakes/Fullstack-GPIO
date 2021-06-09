<?php

namespace App\Services\DeviceCommunicationService\Drivers;

use App\Core\Result;
use App\Models\Vacuum;

class VacuumDeviceDriver implements IDriverConnection
{
    public function __construct(Vacuum $vacuum)
    {
        $this->vacuum = $vacuum;
    }

    public function ping(): Result
    {
        return Result::fail('Not implemented');
    }

    public function setPower(bool $power): Result
    {
        return Result::fail('Not implemented');
    }

    public function getPower(): Result
    {
        return Result::fail('Not implemented');
    }
}
