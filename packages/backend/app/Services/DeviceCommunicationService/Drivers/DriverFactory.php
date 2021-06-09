<?php

namespace App\Services\DeviceCommunicationService\Drivers;

use App\Models\Vacuum;

class DriverFactory
{
    public function getDriver(Vacuum $vacuum): IDriverConnection
    {
        return new VacuumDeviceDriver($vacuum);
    }
}
