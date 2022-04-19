<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class DeviceCheckin implements ShouldBroadcast
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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('devices');
    }

    public function broadcastAs()
    {
        return 'onCheckin';
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
