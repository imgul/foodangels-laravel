<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItemType extends Model
{

    protected $auditColumn = true;
    protected $table       = 'menu_item_types';
    protected $fillable    = ['name', 'status'];


    public function scopeStatus( $query, $status )
    {
        if(!empty($status) && (int) $status) {
            return $query->where(['status' => $status]);
        }
    }

}
