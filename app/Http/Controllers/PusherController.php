<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Events\LessonMessageEvent;
use App\Lesson;
class PusherController extends Controller
{
    public function auth(Request $request) {
        $user = $request->user();
        $socket_id = $request->socket_id;
        $channel_name = $request->channel_name;
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true
            ]
        );
        return response(
            $pusher->presence_auth($channel_name, $socket_id, $user->id, [
                'id' => $user->id,
                'name' => $user->name
            ])
        );
    }
    public function lessonMessage(Request $request, Lesson $lesson){
        if($lesson->student_id != auth()->id() && $lesson->teacher_id != auth()->id()) return response()->json(['Permission denied', 403]);
        $message = $lesson->messages()->create([
            'text' => $request->text,
            'user_id' => auth()->id()
        ]);
        $message->load(['user:id,name']);
        event(new LessonMessageEvent($message));
        return $message;
    }
}
