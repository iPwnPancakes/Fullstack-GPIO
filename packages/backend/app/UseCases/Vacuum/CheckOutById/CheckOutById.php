<?php


namespace App\UseCases\Vacuum\CheckOutById;


use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;

class CheckOutById extends UseCase
{
    private $vacuumRepository;

    public function __construct(IVacuumRepository $vacuumRepository)
    {
        $this->vacuumRepository = $vacuumRepository;
    }

    /**
     * @param CheckOutByIdDTO $request
     *
     * @return Result<void>
     *
     * @throws \Exception
     */
    function execute(Request $request): Result
    {
        $exists = $this->vacuumRepository->exists($request->vacuum_ip);

        if (!$exists) {
            return Result::fail('Vacuum does not exist');
        }

        $vacuum = $this->vacuumRepository->getVacuumByVacuumID($request->vacuum_ip);

        $vacuum->connected = false;

        $this->vacuumRepository->save($vacuum);

        return Result::ok();
    }
}
