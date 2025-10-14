<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MongoOrderItem extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price'];
}