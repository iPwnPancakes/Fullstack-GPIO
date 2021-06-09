<?php

namespace App\Console\Commands;

use App\UseCases\Pins\SetPinPower\SetPinPower;
use App\UseCases\Pins\SetPinPower\SetPinPowerDTO;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetGpioPinState extends Command
{
    protected $signature = 'gpio:set {pin_number} {direction}';

    private $setGpioPinStateCommand;

    public function __construct(SetPinPower $setGpioPinStateCommand)
    {
        parent::__construct();

        $this->setGpioPinStateCommand = $setGpioPinStateCommand;
    }

    public function handle()
    {
        try {
            $pin = $this->argument('pin_number');
            $direction = $this->argument('direction');

            $dto = new SetPinPowerDTO();
            $dto->pin_number = $pin;

            if ($direction === 'out') {
                $dto->pin_power_state = true;
            } else {
                $dto->pin_power_state = false;
            }

            $result = $this->setGpioPinStateCommand->execute($dto);

            if ($result->isFailure()) {
                throw new Exception('Could not set state of GPIO pin');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
