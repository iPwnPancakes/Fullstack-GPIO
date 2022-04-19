<?php

namespace App\UseCases\Pins\GetPinState;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\Pins\IPinRepository;

class GetPinState extends UseCase
{
    private $pinRepo;

    public function __construct(IPinRepository $pinRepo)
    {
        $this->pinRepo = $pinRepo;
    }

    /**
     * @param GetPinStateDTO $request
     *
     * @return GetPinStateResponseDTO
     */
    public function execute(Request $request): Result
    {
        $exists = $this->pinRepo->exists($request->pin_number);

        if (!$exists) {
            return Result::fail('Pin does not exist');
        }

        $pin = $this->pinRepo->getPinByPinNumber($request->pin_number);

        $response_dto = new GetPinStateResponseDTO([
            'pin_number' => $pin->getPinNumber(),
            'power_state' => $pin->getPowerState()
        ]);

        return Result::ok($response_dto);
    }
}
