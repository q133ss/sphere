<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['start', 'end', 'student_id', 'teacher_id', 'subject_id', 'payment_id'];
    protected $dates = ['start', 'end', 'created_at', 'updated_at'];
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function messages(){
        return $this->morphMany(Message::class, 'messageable');
    }
    public function payment(){
        return $this->belongsTo(Payment::class);
    }
    public function lesson_boards(){
        return $this->hasMany(LessonBoard::class);
    }
    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
