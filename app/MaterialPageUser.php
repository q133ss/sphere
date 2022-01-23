<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MaterialPageUser extends Model
{
    protected $fillable = ['page', 'user_id', 'material_id'];
}
