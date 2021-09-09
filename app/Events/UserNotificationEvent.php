<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Notification;
class UserNotificationEvent  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public function __construct($user_id, $text)
    {
        $this->notification = Notification::create([
            'user_id' => $user_id,
            'text' => $text,
            'read' => false
        ]);
    }
    public function broadcastOn()
    {
        return new PresenceChannel('App.Models.User.'.$this->notification->user_id);
    }
}
