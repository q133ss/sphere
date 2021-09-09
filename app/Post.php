<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'preview_text', 'detail_text', 'preview_picture', 'detail_picture'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
