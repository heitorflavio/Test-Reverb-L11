<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateCalendar implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Appointment $event;

    /**
     * Create a new event instance.
     */
    public function __construct($appointment)
    {
        Log::info('UpdateCalendar event fired');
        Log::info($appointment);
        $this->event = $appointment;
    }
  

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('Calendar'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'Calendar';
    }

    public function broadcastWith(): array 
    {
        return [
            'event' => $this->event,
        ];
    }
}
