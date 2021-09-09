<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;
    protected $fillable = ['subject_id', 'teacher_id', 'student_id', 'start', 'end'];
    protected $dates = ['start', 'end'];
    protected $casts = [
        'start'  => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
    public function lesson(){
        return $this->hasOne(Lesson::class);
    }
}
