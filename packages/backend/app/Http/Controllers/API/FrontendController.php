<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCases\Vacuum\GetConnectionInformation\{GetConnectionInformation, GetConnectionInformationDTO, GetConnectionInformationResponseDTO};
use App\UseCases\Vacuum\Ping\{Ping, PingDTO};
use App\UseCases\Vacuum\SetPower\{SetPower, SetPowerDTO};
use Exception;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    private $getConnectionInformationQuery;
    private $pingCommand;
    private $setPowerCommand;

    public function __construct(GetConnectionInformation $getConnectionInformationQuery, Ping $pingCommand, SetPower $setPowerCommand)
    {
        $this->getConnectionInformationQuery = $getConnectionInformationQuery;
        $this->pingCommand = $pingCommand;
        $this->setPowerCommand = $setPowerCommand;
    }

    public function getConnectionInformation(Request $request)
    {
        try {
            $dto = new GetConnectionInformationDTO($request->toArray());

            $result = $this->getConnectionInformationQuery->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            /** @var GetConnectionInformationResponseDTO */
            $response = $result->getValue();

            return response()->json($response->toArray(), 200);
        } catch (Exception $e) {
            $message = $e->getMessage() ?? 'Unhandled Exception';
            $code = $e->getCode() ? $e->getCode() : 500;

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], $code);
        }
    }

    public function ping($id)
    {
        try {
            $dto = new PingDTO(['vacuum_id' =>  $id]);

            $result = $this->pingCommand->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            $message = $e->getMessage() ?? 'Unhandled Exception';
            $code = $e->getCode() ? $e->getCode() : 500;

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], $code);
        }
    }

    public function setPower(Request $request)
    {
        try {
            $dto = new SetPowerDTO($request->toArray());

            $result = $this->setPowerCommand->execute($dto);

            if ($result->isFailure()) {
                return response()->json(['errors' => $result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            $message = $e->getMessage() ?? 'Unhandled Exception';
            $code = $e->getCode() ? $e->getCode() : 500;

            return response()->json([
                'errors' => ['unhandled' => $message],
            ], $code);
        }
    }
}
