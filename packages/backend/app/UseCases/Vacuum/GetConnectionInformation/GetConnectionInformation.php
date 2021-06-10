<?php

namespace App\UseCases\Vacuum\GetConnectionInformation;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\IVacuumRepository;
use Carbon\Carbon;

class GetConnectionInformation extends UseCase
{
    private $vacuumRepo;

    public function __construct(IVacuumRepository $vacuumRepo)
    {
        $this->vacuumRepo = $vacuumRepo;
    }

    /**
     * @param GetLastCommunicationDTO $request
     *
     * @return Result<GetLastCommunicationResponseDTO>
     */
    public function execute(Request $request): Result
    {
        $exists = $this->vacuumRepo->exists($request->vacuum_id);

        if (!$exists) {
            return Result::fail('Vacuum does not exist');
        }

        $vacuum = $this->vacuumRepo->getVacuumByVacuumID($request->vacuum_id);

        $response_dto = new GetConnectionInformationResponseDTO([
            'connected' => $vacuum->connected,
            'last_communication_at' => $vacuum->last_communication_at,
            'last_communication_attempt_at' => $vacuum->last_communication_attempt_at
        ]);

        return Result::ok($response_dto);
    }
}