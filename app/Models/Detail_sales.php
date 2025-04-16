<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_sales extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'sub_total',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }
}
