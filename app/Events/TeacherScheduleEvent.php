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
    public $events;
    public $teacher_id;
    public function __construct($teacher_id, $type, $events)
    {
        $this->type = $type;
        $this->teacher_id = $teacher_id;
        $this->events = $events;
    }
    public function broadcastOn()
    {
        return new PrivateChannel('schedule-channel-' . $this->teacher_id);
    }
}
