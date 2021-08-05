<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class DeviceCheckedOut implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public int    $device_id,
        public Carbon $checkinTime,
        public bool   $power_status
    )
    {
        Log::debug('Event Dispatched: ' . self::class);
    }

    public function broadcastOn()
    {
        return new Channel('devices');
    }

    public function broadcastAs()
    {
        return 'onCheckout';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->device_id,
            'power_status' => $this->power_status,
            'checkin_time' => $this->checkinTime
        ];
    }
}
