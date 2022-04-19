<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCases\Vacuum\CheckIn\{CheckIn, CheckInDTO};
use App\UseCases\Vacuum\CheckOutByPublicIP\{CheckOutByPublicIP, CheckOutByPublicIPDTO};
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private $checkInCommand;
    private $checkOutCommand;

    public function __construct(CheckIn $checkInCommand, CheckOutByPublicIP $checkOutCommand)
    {
        $this->checkInCommand = $checkInCommand;
        $this->checkOutCommand = $checkOutCommand;
    }

    public function check_in(Request $request): JsonResponse
    {
        $validator = Validator::make($request->toArray(), [
            'pin_number' => 'required|numeric',
            'pin_power' => 'required|boolean'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $dto = new CheckInDTO([
                'public_ip' => $request->ip(),
                'port' => $request->getPort(),
                'pin_number' => $request->get('pin_number'),
                'pin_state' => $request->get('pin_power')
            ]);

            $check_in_result = $this->checkInCommand->execute($dto);

            if ($check_in_result->isFailure()) {
                return response()->json(['errors' => $check_in_result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok']);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['errors' => [$e->getMessage()]], 500);
        }
    }

    public function check_out(Request $request): JsonResponse
    {
        try {
            $dto = new CheckOutByPublicIPDTO(['public_ip' => $request->ip()]);

            $check_out_result = $this->checkOutCommand->execute($dto);

            if ($check_out_result->isFailure()) {
                return response()->json(['errors' => $check_out_result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok']);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['errors' => [$e->getMessage()]], 500);
        }
    }
}
