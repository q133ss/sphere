<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeacherScheduleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $event;
    public function __construct($type, $event)
    {
        $this->type = $type;
        $this->event = $event;
    }
    public function broadcastAs()
    {
        return 'event';
    }
    public function broadcastOn()
    {
        return ['schedule.'.$this->event->teacher_id];
    }
}
