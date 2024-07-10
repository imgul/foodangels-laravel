<?php

namespace App\Models;


use App\Models\BaseModel;

class Promo extends BaseModel
{

    protected $table       = 'promos';
    protected $fillable    = [
        'name',
        'discount_type',
        'amount',
        'restaurant_id',
        'from_date',
        'to_date'.'status',
        'user_limit'
    ];



    public function getActionButtonAttribute()
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID > 1) {
            if(auth()->user()->restaurant_id != 0){
                $this->restaurant_id == auth()->user()->restaurant_id;
                return 0;
            }
            return false;
        }
        return true;
    }

    public function isvalid()
    {
        $today = strtotime(date('Y-m-d H:i:s'));
        $starts_at = strtotime($this->from_date);
        $ends_at = strtotime($this->to_date);

        if($today > $starts_at && $today < $ends_at){
            return true;
        }
        return false;
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function promoMenus()
    {
        return $this->hasMany(PromotionMenus::class,'promo_id');
    }





}
