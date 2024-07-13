<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\Status;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Reward;
use Illuminate\Http\Request;

class RedeemController extends Controller
{
    public function store($reward_id)
    {

        $reward = Reward::query()->with(['menus', 'menuItems', 'user'])->where(['id' => $reward_id, 'redeemed' => 0])->first();

        $total = 0;

        $menus = [];


        foreach ($reward->menuItems as $menu) {
            $total += $menu->unit_price;
        }

        if ($reward->redeemed == 0) {


            $order = Order::create([
                'user_id' => $reward->user->id,
                'total' => $total,
                'sub_total' => $total,
                'paid_amount' => 0,
                'status' => OrderStatus::PENDING
            ]);

            $order_id = $order->id;


            foreach ($reward->menuItems as $menu) {

                $menus[] = ['menu_item_id' => $menu->id, 'order_id' => $order_id, 'quantity' => 1, 'unit_price' => $menu->unit_price, 'item_total' => $menu->unit_price];
            }


            OrderLineItem::insert($menus);

            $reward->update([
                'redeemed' => 1
            ]);

            return redirect(route('account.order.show', $order_id));
        }else {
                return redirect(route('rewards'))->withError('You have already redeem this menu');
        }
       
    }
}
