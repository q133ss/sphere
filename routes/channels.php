<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{userId}', function ($userId) {
    return true;
});
Broadcast::channel('lesson.{lessonId}', function($lessonId){
    return true;
});
Broadcast::channel('schedule.{teacherId}', function($teacherId){
    return true;
});

Broadcast::channel('presence-video-channel', function($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('schedule-channel-{teacher_id}', function($teacher_id) {
    return true;
});