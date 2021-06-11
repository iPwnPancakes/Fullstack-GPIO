<?php

namespace App\UseCases\Pins\SetPinPower;

use App\Core\Request;
use App\Core\Result;
use App\Core\UseCase;
use App\Repositories\Pins\IPinRepository;

class SetPinPower extends UseCase
{
    private $pinRepo;

    public function __construct(IPinRepository $pinRepo)
    {
        $this->pinRepo = $pinRepo;
    }

    /**
     * @param SetPinPowerDTO $request
     *
     * @return Result<void>
     */
    public function execute(Request $request): Result
    {
        $exists = $this->pinRepo->exists($request->pin_number);

        if (!$exists) {
            return Result::fail('Pin does not exist');
        }

        $pin = $this->pinRepo->getPinByPinNumber($request->pin_number);

        $pin->setPowerState((bool)$request->pin_power_state);

        $this->pinRepo->save($pin);

        return Result::fail('Not implemented');
    }
}
