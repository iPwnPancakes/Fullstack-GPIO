<?php

namespace App\Jobs;

use App\UseCases\Vacuum\CheckIfVacuumTimeout\CheckIfVacuumTimeout;
use App\UseCases\Vacuum\CheckIfVacuumTimeout\CheckIfVacuumTimeoutDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckIfVacuumTimedOut implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CheckIfVacuumTimeout $checkIfVacuumTimeoutCommand)
    {
        try {
            $result = $checkIfVacuumTimeoutCommand->execute(new CheckIfVacuumTimeoutDTO());

            if ($result->isFailure()) {
                throw new \Exception($result->getErrors()[0] ?? null);
            }
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
        }
    }
}
