<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class DeviceCheckin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $device_id;
    public $checkinTime;
    public $power_status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $device_id, Carbon $checkinTime, bool $power_status)
    {
        $this->device_id = $device_id;
        $this->checkinTime = $checkinTime;
        $this->power_status = $power_status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
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
