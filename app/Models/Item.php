<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'icon',
        'allowed_roles'
    ];

    // TODO: Implement permissions by setting an allowed roles attribute
}
