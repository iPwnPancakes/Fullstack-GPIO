<?php

namespace App\UseCases\Vacuum\CheckOut;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;
use Carbon\Carbon;

class CheckOut extends UseCase
{
    private $vacuumRepo;

    public function __construct(IVacuumRepository $vacuumRepo)
    {
        $this->vacuumRepo = $vacuumRepo;
    }

    /**
     * @param CheckOutDTO $request
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

        return Result::ok();
    }
}
