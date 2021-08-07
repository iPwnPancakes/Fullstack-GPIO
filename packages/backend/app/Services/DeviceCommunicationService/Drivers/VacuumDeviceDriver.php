<?php

namespace App\Services\DeviceCommunicationService\Drivers;

use App\Core\Result;
use App\Models\Vacuum;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VacuumDeviceDriver implements IDriverConnection
{
    private $vacuum;

    public function __construct(Vacuum $vacuum)
    {
        $this->vacuum = $vacuum;
    }

    public function ping(): Result
    {
        try {
            $response = Http::get($this->vacuum->public_ip . ':' . $this->vacuum->port . '/ping');

            if (!$response->ok()) {
                return Result::fail('Response received from device not ok');
            }

            $json = $response->json();

            if ($json === null) {
                return Result::fail('Invalid response from device');
            }

            return Result::ok();
        } catch (ConnectException $e) {
            return Result::fail('Could not connect to device');
        } catch (Exception $e) {
            return Result::fail('Failure to communicate with vacuum device');
        }
    }

    public function setPower(bool $power): Result
    {
        try {
            $response = Http::post(
                $this->vacuum->public_ip . ':' . $this->vacuum->port . '/setPower',
                ['power' => $power]
            );

            if (!$response->ok()) {
                return Result::fail('Response received from device not ok');
            }

            $json = $response->json();

            if ($json === null) {
                return Result::fail('Invalid response from device');
            }

            return Result::ok();
        } catch (ConnectException $e) {
            return Result::fail('Could not connect to device');
        } catch (Exception $e) {
            return Result::fail('Failure to communicate with vacuum device');
        }
    }

    /**
     * @inheritDoc
     */
    public function getPower(): Result
    {
        try {
            $response = Http::get($this->vacuum->public_ip . ':' . $this->vacuum->port . '/getStatus');

            if (!$response->ok()) {
                return Result::fail('Device response received but did not have 200 status');
            }

            $json = $response->json();

            if (($json['data']['power'] ?? null) === null) {
                return Result::fail('Device response invalid JSON');
            }

            return Result::ok((bool)$json['data']['power']);
        } catch (ConnectException $e) {
            return Result::fail('Could not connect to device');
        } catch (Exception $e) {
            return Result::fail('Failure to communicate with vacuum device');
        }
    }
}
