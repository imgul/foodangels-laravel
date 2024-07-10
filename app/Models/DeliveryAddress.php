<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryAddress extends Model
{
    // street_name, house_number, floor (optional), city, postal_code, company_name (optional), note (optional), user_id (foreign key)
    protected $fillable = [
        'street_name',
        'house_number',
        'floor',
        'city',
        'postal_code',
        'company_name',
        'note',
        'user_id'
    ];

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
