<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'sale_date',
        'total_price',
        'total_pay',
        'total_return',
        'customer_id',
        'user_id',
        'poin',
        'used_point'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detail_sales()
    {
        return $this->hasMany(Detail_sales::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
