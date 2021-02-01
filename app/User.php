<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'surname', 'name', 'lastname', 'phone', 'about', 'email', 'password', 'age', 'confirm_request', 'lesson_price', 'role_id'
    ];
    protected $appends = ['full_name'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getPhotoAttribute($value){
        return $value ? '/storage/' . $value : '/images/empty-photo.png';
    }
    public function isAdmin(){
        return $this->role_id == 1;
    }
    public function isTeacher(){
        return $this->role_id == 3;
    }
    public function isStudent(){
        return $this->role_id == 2;
    }
    public function getFullNameAttribute($value){
        return $this->surname .' '. $this->name .' '. $this->lastname;
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
    public function students(){
        return $this->belongsToMany(User::class, 'student_teacher', 'teacher_id', 'student_id');
    }
    public function teachers(){
        return $this->belongsToMany(User::class, 'student_teacher', 'student_id', 'teacher_id');
    }
    public function teacher_lessons(){
        return $this->hasMany(Lesson::class, 'teacher_id');
    }
    public function student_lessons(){
        return $this->hasMany(Lesson::class, 'student_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function notifications(){
        return $this->hasMany(Notification::class)->latest();
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class);
    }
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    public function subscribes(){
        return $this->hasMany(Subscribe::class);
    }
    public function activeSubscribe(){
        return $this->subscribes()->where('end', '>=', Carbon::now());
    }
}
