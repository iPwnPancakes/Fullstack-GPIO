<?php


namespace App\UseCases\Vacuum\CheckIfVacuumTimeout;


use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Events\VacuumTimedOut;
use App\Repositories\IVacuumRepository;
use Carbon\Carbon;

class CheckIfVacuumTimeout extends UseCase
{
    private $vacuumRepository;

    public function __construct(IVacuumRepository $vacuumRepository)
    {
        $this->vacuumRepository = $vacuumRepository;
    }

    /**
     * @param CheckIfVacuumTimeoutDTO $request
     *
     * @return Result<void>
     */
    function execute(Request $request): Result
    {
        $exists = $this->vacuumRepository->exists(1);

        if (!$exists) {
            return Result::ok();
        }

        $vacuum = $this->vacuumRepository->getVacuumByVacuumID(1);

        /** @var Carbon $last_communication */
        $last_communication = $vacuum->last_communication_at;

        if (!$vacuum->connected) {
            return Result::ok();
        }

        if ($last_communication->addMinutes(5)->lessThanOrEqualTo(Carbon::now())) {
            VacuumTimedOut::dispatch($vacuum->id);
        }

        return Result::ok();
    }
}
