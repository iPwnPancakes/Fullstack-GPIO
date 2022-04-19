<?php


namespace App\Jobs;


use App\UseCases\Uptime\CheckIntoMainServer\CheckIntoMainServerDTO;
use Illuminate\Support\Facades\Log;

class CheckIntoMainServer extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(\App\UseCases\Uptime\CheckIntoMainServer\CheckIntoMainServer $checkIntoMainServerCommand)
    {
        try {
            $result = $checkIntoMainServerCommand->execute(new CheckIntoMainServerDTO());

            if ($result->isFailure()) {
                throw new \Exception($result->getErrors()[0] ?? 'Unspecified Connection Error');
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

    }
}
