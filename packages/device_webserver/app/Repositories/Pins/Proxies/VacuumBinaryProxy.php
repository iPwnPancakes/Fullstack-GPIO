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
        $result_strings = [];
        $result_code = null;

        exec("sudo vacuum read $pin_number", $result_strings, $result_code);

        if ($result_code !== 0) {
            return Result::fail('Not able to read pin');
        }

        if (empty($result_strings)) {
            return Result::fail('No response given from binary');
        }

        if (!is_string($result_strings[0])) {
            return Result::fail('Invalid response given from binary');
        }

        $tokens = explode(' ', $result_strings[0]);

        $pin_number_str = $tokens[0] ?? null;
        $direction_str = $tokens[1] ?? null;

        if (!is_numeric($pin_number_str)) {
            return Result::fail('Pin number given from binary is not valid');
        }

        if ($direction_str !== 'in' && $direction_str !== 'out') {
            return Result::fail('Pin direction given from binary is not valid');
        }

        return Result::ok(new VacuumBinaryProxyResponseDTO(['pin_number' => (int)$pin_number_str, 'direction' => $direction_str]));
    }

    /**
     * @return Result<void>
     */
    public function write(int $pin_number, bool $power): Result
    {
        $result_strings = [];
        $result_code = null;

        $direction = $power ? 'out' : 'in';

        $command = 'sudo vacuum write ' . $pin_number . ' ' . $direction;
        exec($command, $result_strings, $result_code);

        if ($result_code !== 0) {
            return Result::fail('Not able to write to pin');
        }

        return Result::ok();
    }
}
