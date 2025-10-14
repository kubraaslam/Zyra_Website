<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MongoOrder extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'zip',
        'payment_method',
        'total',
        'order_date',
        'delivery_date'
    ];
}