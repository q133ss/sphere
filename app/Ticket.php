<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['text', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function messages(){
        return $this->morphMany(Message::class, 'messageable');
    }
}
