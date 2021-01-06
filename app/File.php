<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['fileable_id', 'fileable_type', 'name', 'src', 'size', 'ext', 'category'];
    
    public function fileable(){
        return $this->morphTo();
    }
}
