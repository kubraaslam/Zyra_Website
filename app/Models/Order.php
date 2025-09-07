<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

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
        'delivery_date',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    // Relationship: an order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: an order has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}