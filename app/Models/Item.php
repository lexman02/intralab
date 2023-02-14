<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'url',
        'icon',
        'allowed_roles'
    ];
}
