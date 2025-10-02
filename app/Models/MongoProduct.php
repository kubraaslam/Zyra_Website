<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MongoProduct extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $fillable = ['name', 'price', 'category', 'stock', 'status', 'image_url'];
}