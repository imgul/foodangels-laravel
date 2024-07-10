<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantPostalCode extends Model
{
    protected $table = 'restaurant_postal_codes';

    protected $fillable    = [
        'postal_code',
        'restaurant_id',
        'delivery_charge',
        'postal_code',
        'delivery_time',
        'min_order',
        'max_order'
    ];

    // get the postal code which has the lowest delivery charges
//    public static function getLowestDeliveryCharge($postal_code)
//    {
//        $lowest_delivery_charge = RestaurantPostalCode::where('postal_code', $postal_code)->min('delivery_charge');
//        return $lowest_delivery_charge;
//    }

}
