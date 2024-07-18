<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LoyaltyUser;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Reward;
use App\Models\RewardMenu;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $data['rewards'] = Reward::query()->with(['user'])->get();

        return view('admin.rewards.index', $data);
    }

    public function create()
    {

        $data['loyalty_users'] = LoyaltyUser::query()->with(['user'])->groupBy('customer_id')->get();

        $restuarant = Restaurant::query()->where('status', Status::ACTIVE)->first();

        $data['menuItemObj']    = MenuItem::where(['status' => Status::ACTIVE, 'restaurant_id' => $restuarant->id])->get(['name', 'unit_price', 'discount_price', 'id']);
        $data['categoryObj']     = Category::where(['status' => Status::ACTIVE])->get(['name', 'id']);


        return view('admin.rewards.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'loyalty_customer_id' => 'required'
        ]);

        $loyalty_customer_id = $request->loyalty_customer_id;

        $customer_id = explode(',', $loyalty_customer_id)[0];

        $loyalty_user_id = explode(',', $loyalty_customer_id)[1];

        $menu = $request->menu;
        

        $reward =  Reward::create([
            'customer_id' => $customer_id,
            'loyalty_user_id' => $loyalty_user_id
        ]);

        $reward_id = $reward->id;

        $reward_menus = [];

        foreach ($menu as $item) {
          
            $reward_menus[] = ['reward_id' => $reward_id, 'menu_item_id' => $item];
        }
    

        RewardMenu::insert($reward_menus);


       return redirect(route('admin.rewards'))->withSuccess('Reward added successfully');
    }
}
