<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'age',
        'phone',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'user_id');
    }

}
