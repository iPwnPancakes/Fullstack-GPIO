<?php


namespace App\Repositories\MainServer;


use App\Core\Result;
use App\Domain\Pins\Pin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HttpMainServerRepository implements IMainServerRepository
{
    /**
     * @inheritDoc
     */
    public function checkIn(Pin $pin): Result
    {
        $main_server_url = env('MAIN_SERVER_URL');

        try {
            $response = Http::post($main_server_url . '/api/v1/devices/check_in', [
                'pin_number' => $pin->getPinNumber(),
                'pin_power' => $pin->getPowerState()
            ]);

            Log::debug('Checked in');
        } catch (\Exception $e) {
            return Result::fail($e->getMessage());
        }

        if ($response->failed()) {
            return Result::fail('Communication Failure. Response code ' . $response->status());
        }

        return Result::ok();
    }
}
