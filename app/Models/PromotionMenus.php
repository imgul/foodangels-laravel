<?php

namespace App\Models;


use App\Models\BaseModel;

class PromotionMenus extends BaseModel
{
    protected $table       = 'promotion_menus';
    protected $fillable    = [
        'promo_id',
        'menu_id',
        'restaurant_id'
    ];


    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
     public function product()
    {
        return $this->hasOne(MenuItem::class,'id','menu_id')->with('media');
    }
}
