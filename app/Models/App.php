<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'icon',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
