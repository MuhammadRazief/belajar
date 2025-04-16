<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'img',
    ];

    public function detail_sales()
    {
        return $this->hasMany(Detail_sales::class);
    }
}

