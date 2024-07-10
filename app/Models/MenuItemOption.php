<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemOption extends Model
{
    protected $table        = 'menu_item_options';
    protected $fillable     = ['menu_item_id', 'restaurant_id','menu_item_type_id','related_menu_item_id', 'name', 'unit_price','type'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class,'menu_item_id','id');
    }

    public function relatedMenuItem()
    {
        return $this->belongsTo(MenuItem::class,'related_menu_item_id','id');
    }

    public function menuItemType()
    {
        return $this->belongsTo(MenuItemType::class, 'menu_item_type_id','id');
    }
}
