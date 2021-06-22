<?php

namespace App\Listeners;

use App\Events\VacuumTimedOut;
use App\UseCases\Vacuum\CheckOutById\CheckOutById;
use App\UseCases\Vacuum\CheckOutById\CheckOutByIdDTO;
use Illuminate\Support\Facades\Log;

class MarkVacuumDisconnected
{
    private $checkOutCommand;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CheckOutById $checkOutCommand)
    {
        $this->checkOutCommand = $checkOutCommand;
    }

    /**
     * Handle the event.
     *
     * @param VacuumTimedOut $event
     * @return void
     */
    public function handle(VacuumTimedOut $event)
    {
        try {
            $dto = new CheckOutByIdDTO(['vacuum_id' => $event->vacuum_id]);

            $result = $this->checkOutCommand->execute($dto);

            if ($result->isFailure()) {
                throw new \Exception($result->getErrors()[0] ?? null);
            }
        } catch (\Exception $e) {
            Log::error('Unhandled Error: ' . $e->getMessage());
        }
    }
}
