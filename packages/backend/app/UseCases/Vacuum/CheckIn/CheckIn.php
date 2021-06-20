<?php

namespace App\UseCases\Vacuum\CheckIn;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Models\Vacuum;
use App\Repositories\IVacuumRepository;
use Carbon\Carbon;

class CheckIn extends UseCase
{
    private $vacuumRepo;

    public function __construct(IVacuumRepository $vacuumRepo)
    {
        $this->vacuumRepo = $vacuumRepo;
    }

    /**
     * @param CheckInDTO $request
     *
     * @return Result<void>
     */
    public function execute(Request $request): Result
    {
        if(!isset($request->public_ip) || !isset($request->port)) {
            return Result::fail('Must be given a public IP and port');
        }

        $exists = $this->vacuumRepo->existsWithPublicIP($request->public_ip);

        if (!$exists) {
            $vacuum = new Vacuum();
            $vacuum->public_ip = $request->public_ip;
        } else {
            $vacuum = $this->vacuumRepo->getVacuumByPublicIP($request->public_ip);
        }

        $vacuum->port = $request->port;
        $vacuum->connected = true;
        $vacuum->last_communication_at = Carbon::now();

        $this->vacuumRepo->save($vacuum);

        return Result::ok();
    }
}
