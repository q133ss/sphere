<?php

use Illuminate\Support\Facades\Broadcast;
use App\Lesson;

Broadcast::channel('App.Chat', function ($user) {
    return [
        'id' => $user->id,
        'full_name' => $user->full_name
    ];
});

Broadcast::channel('App.Chat.Message.{hash}', function ($user, $hash) {
    $ids = explode('_', $hash);
    return in_array($user->id, $ids);
});

Broadcast::channel('App.Models.Lesson.{lessonId}.Video', function ($user, $lessonId) {
    return $user;
    $lesson = Lesson::find($lessonId);
    if($lesson && ($lesson->teacher_id == $user->id || $lesson->student_id == $user->id))
        return [
            'id' => $user->id,
            'name' => $user->name
        ];
    else return false;
});

Broadcast::channel('App.Models.Lesson.{lessonId}', function ($user, $lessonId) {
    $lesson = Lesson::find($lessonId);
    return $lesson && ($lesson->teacher_id == $user->id || $lesson->student_id == $user->id);
});

Broadcast::channel('App.Models.User.{userId}', function ($user, $userId) {
    return $user->id == $userId;
});

Broadcast::channel('App.Schedule.{teacherId}', function($user, $teacherId){
    return true;
});
