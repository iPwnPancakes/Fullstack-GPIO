<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class DeviceCommunicationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public int $device_id,
        public bool $connected,
        public Carbon $checkinTime,
        public bool $power_status,
        public Carbon $last_communication_attempt_at
    )
    {
        Log::debug('Event Dispatched: ' . self::class);
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
        return 'deviceCommunicationEvent';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->device_id,
            'connected' => $this->connected,
            'power_status' => $this->power_status,
            'checkin_time' => $this->checkinTime,
            'last_communication_attempt_at' => $this->last_communication_attempt_at
        ];
    }
}
