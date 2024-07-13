<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function menus()
    {
        return $this->hasMany(RewardMenu::class);
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'reward_menus')->with('media');
    }
}
