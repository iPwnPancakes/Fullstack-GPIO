<?php

namespace App\Repositories\Pins;

use App\Core\Result;
use App\Domain\Pins\Pin;
use App\Repositories\Pins\IPinRepository;
use App\Repositories\Pins\Proxies\VacuumBinaryProxy;
use App\Repositories\Pins\Proxies\VacuumBinaryProxyResponseDTO;
use Exception;
use Illuminate\Support\Facades\Log;

class VacuumBinaryPinRepository implements IPinRepository
{
    private $proxy;

    public function __construct()
    {
        $this->proxy = new VacuumBinaryProxy();
    }

    public function exists(int $pin_number): bool
    {
        $result = $this->proxy->read($pin_number);

        if ($result->isFailure()) {
            Log::error($result->getErrors()[0] ?? 'Unspecified Error');
            return false;
        }

        return true;
    }

    public function getPinByPinNumber(int $pin_number): Pin
    {
        $result = $this->proxy->read($pin_number);

        if ($result->isFailure()) {
            throw new Exception($result->getErrors()[0] ?? 'Unspecified Error');
        }

        /** @var VacuumBinaryProxyResponseDTO */
        $response = $result->getValue();

        $pin_result = Pin::create($response->pin_number, $response->power);

        if ($pin_result->isFailure()) {
            throw new Exception($pin_result->getErrorMessageBag()->first());
        }

        return $pin_result->getValue();
    }

    public function save(Pin $newPinState): void
    {
        $result = $this->proxy->write($newPinState->getPinNumber(), $newPinState->getPowerState());

        if ($result->isFailure()) {
            throw new Exception($result->getErrorMessageBag()->first());
        }
    }
}
