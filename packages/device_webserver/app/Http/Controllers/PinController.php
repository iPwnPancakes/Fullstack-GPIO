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

    public function getPinState(Request $request): JsonResponse
    {
        $this->validate($request, [
            'pin_number' => 'required|numeric'
        ]);

        $dto = new GetPinStateDTO($request->all());

        $result = $this->getPinStateQuery->execute($dto);

        if ($result->isFailure()) {
            return response()->json([
                'errors' => $result->getErrors()
            ], 500);
        }

        /** @var GetPinStateResponseDTO */
        $response = $result->getValue();

        return response()->json($response->toArray());
    }

    public function setPinPower(Request $request): JsonResponse
    {
        $this->validate($request, [
            'pin_number' => 'required|numeric',
            'power' => 'required|boolean'
        ]);

        $dto = new SetPinPowerDTO($request->all());

        $result = $this->setPinPowerCommand->execute($dto);

        if ($result->isFailure()) {
            return response()->json([
                'errors' => $result->getErrors()
            ], 500);
        }

        return response()->json(['message' => 'ok']);
    }
}
