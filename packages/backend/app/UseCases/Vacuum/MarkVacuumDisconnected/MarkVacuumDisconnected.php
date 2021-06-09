<?php

namespace App\UseCases\Vacuum\MarkVacuumDisconnected;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;

class MarkVacuumDisconnected extends UseCase
{
    private $vacuumRepo;

    public function __construct(IVacuumRepository $vacuumRepo)
    {
        $this->vacuumRepo = $vacuumRepo;
    }

    /**
     * @param MarkVacuumDisconnectedDTO $request
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

        $vacuum->connected = false;

        $this->vacuumRepo->save($vacuum);

        return Result::ok();
    }
}
