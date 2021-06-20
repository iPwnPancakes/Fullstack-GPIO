<?php

namespace App\Repositories\Pins;

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

    public function exists(int $pin): bool
    {
        $result = $this->proxy->read($pin);

        if ($result->isFailure()) {
            Log::error($result->getErrors()[0] ?? 'Unspecified Error');
            return false;
        }

        return true;
    }

    public function getPinByPinNumber(int $pin): Pin
    {
        $result = $this->proxy->read($pin);

        if ($result->isFailure()) {
            throw new Exception($result->getErrors()[0] ?? 'Unspecified Error');
        }

        /** @var VacuumBinaryProxyResponseDTO */
        $response = $result->getValue();

        $pin_result = Pin::create($response->pin_number, $response->power);

        if ($pin_result->isFailure()) {
            throw new Exception($pin_result->getErrorMessageBag()->first());
        }

        /** @var Pin */
        $pin = $pin_result->getValue();

        return $pin;
    }

    public function save(Pin $pin): void
    {
        $result = $this->proxy->write($pin->getPinNumber(), $pin->getPowerState());

        if ($result->isFailure()) {
            throw new Exception($result->getErrorMessageBag()->first());
        }
    }
}
