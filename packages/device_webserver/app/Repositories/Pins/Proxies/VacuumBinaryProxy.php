<?php

namespace App\Repositories\Pins\Proxies;

use App\Core\Result;

class VacuumBinaryProxy
{
    /**
     * @return Result<VacuumBinaryProxyResponseDTO>
     */
    public function read(int $pin_number): Result
    {
        $result = shell_exec("sudo vacuum read $pin_number");
        $result = trim($result);

        if (empty($result)) {
            return Result::fail('No response given from binary');
        }

        if (!is_string($result)) {
            return Result::fail('Invalid response given from binary');
        }

        $tokens = explode(' ', $result);

        $pin_number_str = $tokens[0] ?? null;
        $direction_str = $tokens[1] ?? null;

        if (!is_numeric($pin_number_str)) {
            return Result::fail('Pin number given from binary is not valid');
        }

        if ($direction_str !== 'in' && $direction_str !== 'out') {
            return Result::fail('Pin direction given from binary is not valid');
        }

        $response = new VacuumBinaryProxyResponseDTO();
        $response->pin_number = (int)$pin_number_str;
        $response->power = $direction_str === 'out';

        return Result::ok($response);
    }

    /**
     * @return Result<void>
     */
    public function write(int $pin_number, bool $power): Result
    {
        $direction = $power ? 'out' : 'in';

        $command = 'sudo vacuum write ' . $pin_number . ' ' . $direction;
        $result = shell_exec($command);
        $result = trim($result);

        if (!empty($result)) {
            return Result::fail("Pin Write Response: $result");
        }

        return Result::ok();
    }
}
