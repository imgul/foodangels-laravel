<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends BaseModel
{
    protected $table       = 'order_addresses';
    protected $fillable    = ['street', 'house_number', 'postcode','city','floor','company_name','note','order_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}
