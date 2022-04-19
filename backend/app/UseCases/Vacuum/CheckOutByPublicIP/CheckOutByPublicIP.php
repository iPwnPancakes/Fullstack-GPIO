<?php

namespace App\UseCases\Vacuum\CheckOutByPublicIP;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Events\DeviceCheckedOut;
use App\Repositories\IVacuumRepository;
use Carbon\Carbon;

class CheckOutByPublicIP extends UseCase
{
    private $vacuumRepo;

    public function __construct(IVacuumRepository $vacuumRepo)
    {
        $this->vacuumRepo = $vacuumRepo;
    }

    /**
     * @param CheckOutByPublicIPDTO $request
     *
     * @return Result<void>
     */
    public function execute(Request $request): Result
    {
        $exists = $this->vacuumRepo->existsWithPublicIP($request->public_ip);

        if (!$exists) {
            return Result::fail('No vacuum with that IP exists');
        }

        $vacuum = $this->vacuumRepo->getVacuumByPublicIP($request->public_ip);

        $vacuum->connected = false;
        $vacuum->last_communication_at = Carbon::now();

        $this->vacuumRepo->save($vacuum);

        DeviceCheckedOut::dispatch($vacuum->id, $vacuum->last_communication_at, $vacuum->is_on);

        return Result::ok();
    }
}
