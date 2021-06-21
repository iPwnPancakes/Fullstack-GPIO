<?php


namespace App\UseCases\Uptime\CheckIntoMainServer;


use App\Core\Request;
use App\Core\Result;
use App\Repositories\MainServer\IMainServerRepository;
use App\Repositories\Pins\IPinRepository;

class CheckIntoMainServer extends \App\Core\UseCase
{
    private $mainServerRepo;
    private $pinRepo;

    public function __construct(IMainServerRepository $mainServerRepo, IPinRepository $pinRepo)
    {
        $this->mainServerRepo = $mainServerRepo;
        $this->pinRepo = $pinRepo;
    }

    /**
     * @inheritDoc
     */
    function execute(Request $request): Result
    {
        $pin_number = env('VACUUM_PIN_NUMBER');

        if(!is_numeric($pin_number)) {
            return Result::fail('No pin number set in .env');
        }

        $exists = $this->pinRepo->exists($pin_number);

        if(!$exists) {
            return Result::fail("Pin $pin_number does not exist");
        }

        $pin = $this->pinRepo->getPinByPinNumber($pin_number);

        $result = $this->mainServerRepo->checkIn($pin);

        if ($result->isFailure()) {
            return $result;
        }

        return Result::ok();
    }
}
