<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $data['rewards'] = Reward::query()->with(['menus', 'menuItems', 'user'])->where(['customer_id' => $userId, 'redeemed' => 0])->get();

        return view('frontend.rewards', $data);
    }
}
