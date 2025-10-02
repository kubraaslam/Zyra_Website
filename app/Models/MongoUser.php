<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class MongoUser extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = ['username','email','password','role','membership_plan'];
    protected $hidden = ['password'];
}