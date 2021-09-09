<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public static $status = ['new' => 'В обработке', 'canceled' => 'Отменен', 'success' => 'Выполнен'];
    protected $fillable = ['user_id', 'type', 'amount', 'status'];
}
