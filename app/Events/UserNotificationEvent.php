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

    public $user_id;
    public $text;
    public $id;
    public function __construct($user_id, $text)
    {
        $notification = Notification::create([
            'user_id' => $user_id,
            'text' => $text
        ]);
        $this->user_id = $user_id;
        $this->text = $text;
        $this->id = $notification->id;
    }
    public function broadcastAs()
    {
        return 'new';
    }
    public function broadcastOn()
    {
        return ['user.'.$this->user_id];
    }
}
