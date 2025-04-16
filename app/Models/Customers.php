<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = [
        'name',
        'no_hp',
        'poin',
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
