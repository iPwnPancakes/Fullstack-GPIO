<?php

namespace App\Console\Commands;

use App\UseCases\Pins\GetPinState\GetPinState;
use App\UseCases\Pins\GetPinState\GetPinStateDTO;
use App\UseCases\Pins\GetPinState\GetPinStateResponseDTO;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReadPinState extends Command
{
    protected $signature = 'gpio:read {pin_number}';

    private $getGpioPinStateCommand;

    public function __construct(GetPinState $getGpioPinStateCommand)
    {
        parent::__construct();

        $this->getGpioPinStateCommand = $getGpioPinStateCommand;
    }

    public function handle()
    {
        try {
            $pin = $this->argument('pin_number');

            $dto = new GetPinStateDTO();
            $dto->pin_number = $pin;

            $result = $this->getGpioPinStateCommand->execute($dto);

            if ($result->isFailure()) {
                throw new Exception($result->getErrorMessageBag()->first());
            }

            /** @var GetPinStateResponseDTO */
            $pin = $result->getValue();

            Log::debug($pin->toArray());
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw $e;
        }
    }
}
