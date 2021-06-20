<?php


namespace App\Jobs;


use App\Repositories\MainServer\IMainServerRepository;

class CheckIntoMainServer extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(IMainServerRepository $mainServerRepository)
    {
        $result = $mainServerRepository->checkIn();

        if($result->isFailure()) {
            throw new \Exception($result->getErrors()[0] ?? 'Unspecified Connection Error');
        }
    }
}
