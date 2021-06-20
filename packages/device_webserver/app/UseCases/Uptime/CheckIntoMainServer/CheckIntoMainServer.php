<?php


namespace App\UseCases\Uptime\CheckIntoMainServer;


use App\Core\Request;
use App\Core\Result;
use App\Repositories\MainServer\IMainServerRepository;

class CheckIntoMainServer extends \App\Core\UseCase
{
    private $mainServerRepo;

    public function __construct(IMainServerRepository $mainServerRepo)
    {
        $this->mainServerRepo = $mainServerRepo;
    }

    /**
     * @inheritDoc
     */
    function execute(Request $request): Result
    {
        $result = $this->mainServerRepo->checkIn();

        if ($result->isFailure()) {
            return $result;
        }

        return Result::ok();
    }
}
