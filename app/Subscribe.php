<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    public $timestamps = false;
    protected $fillable = ['start', 'end', 'user_id', 'months'];
    protected $dates = ['start', 'end'];
}
