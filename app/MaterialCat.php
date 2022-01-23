<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MaterialCat extends Model
{
    use NodeTrait;
    public $timestamps = false;
    protected $fillable = ['name'];
}
