<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'allowed_roles',
    ];

    public function apps()
    {
        return $this->hasMany(App::class);
    }

    public function syncToConfig()
    {

    }
}
