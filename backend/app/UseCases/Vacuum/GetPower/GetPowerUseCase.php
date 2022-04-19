<?php


namespace App\UseCases\Vacuum\GetPower;


use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;
use App\Services\DeviceCommunicationService\DeviceCommunicationService;
use App\Services\DeviceCommunicationService\Drivers\IDriverConnection;
use Carbon\Carbon;

class GetPowerUseCase extends UseCase
{
    public function __construct(
        private IVacuumRepository $vacuumRepo,
        private DeviceCommunicationService $deviceCommunicationService
    )
    {
    }

    /**
     * @param GetPowerDTO $request
     * @return Result<GetPowerResponse>
     */
    function execute(Request $request): Result
    {
        $device_exists = $this->vacuumRepo->exists($request->device_id);

        if (!$device_exists) {
            return Result::fail('Device does not exist');
        }

        $device = $this->vacuumRepo->getVacuumByVacuumID($request->device_id);

        $getDriverResult = $this->deviceCommunicationService->getDriver($device);

        if ($getDriverResult->isFailure()) {
            return $getDriverResult;
        }

        /** @var IDriverConnection $driver */
        $driver = $getDriverResult->getValue();

        $getPowerResult = $driver->getPower();

        if ($getPowerResult->isFailure()) {
            return $getPowerResult;
        }

        $device->is_on = $getPowerResult->getValue();

        $this->vacuumRepo->save($device);

        $response = new GetPowerResponse([]);
        $response->device_id = $request->device_id;
        $response->attempt_time = Carbon::now();
        $response->last_communication_at = $device->last_communication_at;
        $response->pin_power = $device->is_on;

        return Result::ok($response);
    }
}
