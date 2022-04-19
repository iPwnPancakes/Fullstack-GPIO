<?php


namespace App\Repositories\Pins;


use App\Domain\Pins\Pin;
use Illuminate\Support\Collection;

class InMemoryPinRepository implements IPinRepository
{
    /**
     * @var Collection<Pin>
     */
    private $pinCollection;

    public function __construct()
    {
        $this->pinCollection = collect([
            Pin::create(1, false)->getValue(),
            Pin::create(45, false)->getValue()
        ]);
    }

    public function exists(int $pin_number): bool
    {
        return (bool)$this->pinCollection->first(function (Pin $pin) use ($pin_number) {
            return $pin->getPinNumber() === $pin_number;
        });
    }

    public function getPinByPinNumber(int $pin_number): Pin
    {
        $pin = $this->pinCollection->first(function (Pin $pin) use ($pin_number) {
            return $pin->getPinNumber() === $pin_number;
        });

        if ($pin === false) {
            throw new \Exception('Pin was not found');
        }

        return $pin;
    }

    public function save(Pin $newPinState): void
    {
        // Noop
        // We dont have to do anything since when we retrieve in-memory Pins, we retrieve them by reference. So any
        // operations performed on the Pin in the system is immediately reflected in the collection
    }
}
