<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['author_id', 'hash', 'text'];
    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }
}
