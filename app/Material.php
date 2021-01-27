<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'subject_id'];
    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
