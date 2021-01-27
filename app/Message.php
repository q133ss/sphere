<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'text', 'messageable_id', 'messageable_type'];
    protected $with = ['user:id,name,surname,lastname'];
    public function messageable(){
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
