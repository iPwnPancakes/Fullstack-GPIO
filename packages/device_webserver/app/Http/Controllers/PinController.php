<?php

namespace App\Http\Controllers;

use App\UseCases\Pins\GetPinState\GetPinState;
use App\UseCases\Pins\GetPinState\GetPinStateDTO;
use App\UseCases\Pins\GetPinState\GetPinStateResponseDTO;
use App\UseCases\Pins\SetPinPower\SetPinPower;
use App\UseCases\Pins\SetPinPower\SetPinPowerDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PinController extends Controller
{
    private $setPinPowerCommand;
    private $getPinStateQuery;

    public function __construct(SetPinPower $setPinPowerCommand, GetPinState $getPinStateQuery)
    {
        $this->setPinPowerCommand = $setPinPowerCommand;
        $this->getPinStateQuery = $getPinStateQuery;
    }

    public function getPinState(): JsonResponse
    {
        $dto = new GetPinStateDTO();
        $dto->pin_number = env('VACUUM_PIN_NUMBER', null);

        $result = $this->getPinStateQuery->execute($dto);

        if ($result->isFailure()) {
            return response()->json([
                'errors' => $result->getErrors()
            ], 500, ['Content-Type' => 'application/json']);
        }

        /** @var GetPinStateResponseDTO $response */
        $response = $result->getValue();

        return response()->json([
            'data' => [
                'power' => $response->power_state,
                'pin_number' => $response->pin_number
            ]
        ],
            200, ['Content-Type' => 'application/json']);
    }

    public function setPinPower(Request $request): JsonResponse
    {
        $this->validate($request, [
            'pin_number' => 'required|numeric',
            'pin_power_state' => 'required|boolean'
        ]);

        $dto = new SetPinPowerDTO($request->all());

        $result = $this->setPinPowerCommand->execute($dto);

        if ($result->isFailure()) {
            return response()->json([
                'errors' => $result->getErrors()
            ], 500, ['Content-Type' => 'application/json']);
        }

        return response()->json(['message' => 'ok'], 200, ['Content-Type' => 'application/json']);
    }
}
