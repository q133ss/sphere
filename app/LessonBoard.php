<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonBoard extends Model
{
    protected $fillable = ['lesson_id', 'data', 'type', 'name'];
    public $timestamps = false;
}
