<?php

namespace App\UseCases\Vacuum\Ping;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;
use App\Services\DeviceCommunicationService\DeviceCommunicationService;
use App\Services\DeviceCommunicationService\Drivers\IDriverConnection;
use Carbon\Carbon;

class Ping extends UseCase
{
    private $vacuumRepo;
    private $deviceCommunicationService;

    public function __construct(IVacuumRepository $vacuumRepo, DeviceCommunicationService $deviceCommunicationService)
    {
        $this->vacuumRepo = $vacuumRepo;
        $this->deviceCommunicationService = $deviceCommunicationService;
    }

    /**
     * @param PingDTO $request
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

        $vacuum->last_communication_attempt_at = Carbon::now();

        $this->vacuumRepo->save($vacuum);

        $driver_result = $this->deviceCommunicationService->getDriver($vacuum);

        if ($driver_result->isFailure()) {
            return $driver_result;
        }

        /** @var IDriverConnection */
        $driver = $driver_result->getValue();

        $ping_result = $driver->ping();

        if ($ping_result->isFailure()) {
            return $ping_result;
        }

        return Result::ok();
    }
}
