<?php

namespace App\UseCases\Vacuum\SetPower;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;
use App\Services\DeviceCommunicationService\DeviceCommunicationService;
use App\Services\DeviceCommunicationService\Drivers\IDriverConnection;

class SetPower extends UseCase
{
    private $vacuumRepo;
    private $deviceCommunicationService;

    public function __construct(IVacuumRepository $vacuumRepo, DeviceCommunicationService $deviceCommunicationService)
    {
        $this->vacuumRepo = $vacuumRepo;
        $this->deviceCommunicationService = $deviceCommunicationService;
    }

    /**
     * @param SetPowerDTO $request
     *
     * @return Result<void>
     */
    public function execute(Request $request): Result
    {
        $exists = $this->vacuumRepo->exists($request->vacuum_id);

        if (!$exists) {
            return Result::fail('Vacuum does not exist');
        }

        $vacuum = $this->vacuumRepo->getVacuumByVacuumID($request->vacuum_id);

        $driver_result = $this->deviceCommunicationService->getDriver($vacuum);

        if ($driver_result->isFailure()) {
            return $driver_result;
        }

        /** @var IDriverConnection */
        $driver = $driver_result->getValue();

        $set_power_result = $driver->setPower((bool)$request->power_state);

        if ($set_power_result->isFailure()) {
            return $set_power_result;
        }

        return Result::ok();
    }
}
