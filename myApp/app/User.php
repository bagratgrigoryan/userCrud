<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Images;

class Users extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'age',
        'phone',
        'avatar'
    ];
    public function Users()
    {
        return $this->hasMany(Images::class, 'user_id');
    }
}
