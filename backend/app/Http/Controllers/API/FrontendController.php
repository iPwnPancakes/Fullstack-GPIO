<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCases\Vacuum\GetPower\GetPowerDTO;
use App\UseCases\Vacuum\GetPower\GetPowerUseCase;
use App\UseCases\Vacuum\GetConnectionInformation\{GetConnectionInformation,
    GetConnectionInformationDTO,
    GetConnectionInformationResponseDTO
};
use Illuminate\Http\JsonResponse;
use App\UseCases\Vacuum\Ping\{Ping, PingDTO};
use App\UseCases\Vacuum\SetPower\{SetPower, SetPowerDTO};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function __construct(
        private GetConnectionInformation $getConnectionInformationQuery,
        private Ping $pingCommand,
        private SetPower $setPowerCommand,
        private GetPowerUseCase $getPowerUseCase
    )
    {
    }

    public function getConnectionInformation(Request $request, $id)
    {
        try {
            $dto = new GetConnectionInformationDTO(['vacuum_id' => $id]);

            $result = $this->getConnectionInformationQuery->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            /** @var GetConnectionInformationResponseDTO */
            $response = $result->getValue();

            return response()->json($response->toArray(), 200);
        } catch (Exception $e) {
            Log::error($e);
            $message = $e->getMessage() ?? 'Unhandled Exception';

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], 500);
        }
    }

    public function ping($id)
    {
        try {
            $dto = new PingDTO(['vacuum_id' => $id]);

            $result = $this->pingCommand->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            Log::error($e);
            $message = $e->getMessage() ?? 'Unhandled Exception';

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], 500);
        }
    }

    public function setPower(Request $request, $id)
    {
        try {
            $request->validate([
                'power' => 'required|boolean'
            ]);

            $dto = new SetPowerDTO($request->toArray());
            $dto->vacuum_id = $id;
            $dto->power_state = $request->get('power');

            $result = $this->setPowerCommand->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            Log::error($e);
            $message = $e->getMessage() ?? 'Unhandled Exception';

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], 500);
        }
    }

    public function getPower($id): JsonResponse
    {
        try {
            $dto = new GetPowerDTO([]);
            $dto->device_id = $id;

            $result = $this->getPowerUseCase->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 403);
            }

            return response()->json(['data' => $result->getValue()]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json(['errors' => [$e->getMessage()]], 500);
        }
    }
}
