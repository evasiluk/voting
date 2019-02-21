<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['color', 'slug', 'title'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

