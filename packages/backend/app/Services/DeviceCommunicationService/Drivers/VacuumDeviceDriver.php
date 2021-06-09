<?php

namespace App\Services\DeviceCommunicationService\Drivers;

use App\Core\Result;
use App\Models\Vacuum;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;

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
            $response = Http::get($this->vacuum->public_ip . ':' . $this->vacuum->port . '/setPower?power=' . $power);

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

    public function getPower(): Result
    {
        try {
            $response = Http::get($this->vacuum->public_ip . ':' . $this->vacuum->port . '/getPower');

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
}
