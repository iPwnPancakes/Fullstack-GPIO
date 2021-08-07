<?php

namespace App\UseCases\Vacuum\SetPower;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Events\DeviceCommunicationEvent;
use App\Repositories\IVacuumRepository;
use App\Services\DeviceCommunicationService\DeviceCommunicationService;
use App\Services\DeviceCommunicationService\Drivers\IDriverConnection;
use Carbon\Carbon;

class SetPower extends UseCase
{
    public function __construct(
        private IVacuumRepository $vacuumRepo,
        private DeviceCommunicationService $deviceCommunicationService
    )
    {
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
        $vacuum->last_communication_attempt_at = Carbon::now();

        $driver_result = $this->deviceCommunicationService->getDriver($vacuum);

        if ($driver_result->isFailure()) {
            return $driver_result;
        }

        /** @var IDriverConnection */
        $driver = $driver_result->getValue();

        $set_power_result = $driver->setPower((bool)$request->power_state);

        if ($set_power_result->isFailure()) {
            $this->vacuumRepo->save($vacuum);

            DeviceCommunicationEvent::dispatch(
                $vacuum->id,
                $vacuum->connected,
                $vacuum->last_communication_at,
                $vacuum->is_on,
                $vacuum->last_communication_attempt_at
            );

            return $set_power_result;
        }

        $vacuum->last_communication_at = Carbon::now();
        $this->vacuumRepo->save($vacuum);

        DeviceCommunicationEvent::dispatch(
            $vacuum->id,
            $vacuum->connected,
            $vacuum->last_communication_at,
            $vacuum->is_on,
            $vacuum->last_communication_attempt_at
        );

        return Result::ok();
    }
}
