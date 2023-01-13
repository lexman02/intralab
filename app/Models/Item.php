<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    public $primaryKey = 'position';

    protected $fillable = [
        'position',
        'name',
        'description',
        'url',
        'icon',
        'allowed_roles'
    ];
}
