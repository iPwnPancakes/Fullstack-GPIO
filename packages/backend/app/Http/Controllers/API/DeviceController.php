<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\UseCases\Vacuum\CheckIn\{CheckIn, CheckInDTO};
use App\UseCases\Vacuum\CheckOut\{CheckOut, CheckOutDTO};
use Exception;
use Illuminate\Support\Facades\Request;

class DeviceController extends Controller
{
    private $checkInCommand;
    private $checkOutCommand;

    public function __construct(CheckIn $checkInCommand, CheckOut $checkOutCommand)
    {
        $this->checkInCommand = $checkInCommand;
        $this->checkOutCommand = $checkOutCommand;
    }

    public function check_in(Request $request)
    {
        try {
            $dto = new CheckInDTO($request->toArray());

            $check_in_result = $this->checkInCommand->execute($dto);

            if ($check_in_result->isFailure()) {
                return response()->json(['errors' => $check_in_result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode() ? $e->getCode() : 500);
        }
    }

    public function check_out(Request $request)
    {
        try {
            $dto = new CheckOutDTO($request->toArray());

            $check_out_result = $this->checkOutCommand->execute($dto);

            if ($check_out_result->isFailure()) {
                return response()->json(['errors' => $check_out_result->getErrors()], 500);
            }

            return response()->json(['message' => 'ok'], 200);
        } catch (Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode() ? $e->getCode() : 500);
        }
    }
}
