<?php

namespace App\Services\DeviceCommunicationService;

use App\Core\Result;
use App\Models\Vacuum;
use App\Services\DeviceCommunicationService\Drivers\DriverFactory;
use Exception;

class DeviceCommunicationService
{
    private $driverFactory;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driverFactory = $driverFactory;
    }

    public function getDriver(Vacuum $vacuum): Result
    {
        try {
            return Result::ok($this->driverFactory->getDriver($vacuum));
        } catch (Exception $e) {
            return Result::fail('Could not get driver for device');
        }
    }
}
