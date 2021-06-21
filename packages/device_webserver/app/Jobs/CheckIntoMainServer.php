<?php


namespace App\Jobs;


use App\UseCases\Uptime\CheckIntoMainServer\CheckIntoMainServerDTO;

class CheckIntoMainServer extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(\App\UseCases\Uptime\CheckIntoMainServer\CheckIntoMainServer $checkIntoMainServerCommand)
    {
        $result = $checkIntoMainServerCommand->execute(new CheckIntoMainServerDTO());

        if ($result->isFailure()) {
            throw new \Exception($result->getErrors()[0] ?? 'Unspecified Connection Error');
        }
    }
}
