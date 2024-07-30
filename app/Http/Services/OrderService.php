<?php

namespace App\Http\Services;

use App\Enums\DiscountStatus;
use App\Events\OrderReceived;
use App\Models\User;
use App\Models\Order;
use App\Models\Balance;
use App\Models\MenuItem;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Libraries\MyString;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\OrderHistory;
use App\Models\OrderLineItem;
use App\Enums\OrderTypeStatus;
use App\Models\DeliveryBoyAccount;
use App\Enums\ProductReceiveStatus;
use App\Models\Address;
use App\Models\BestSellingCategory;
use App\Models\Discount;
use App\Models\LoyaltyScore;
use App\Models\LoyaltyUser;
use App\Models\RedeemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;

class OrderService
{
    public $adminBalanceId = 1;
    public $commission     = 0;

    public function __construct()
    {
        $this->commission = setting('order_commission_percentage');
    }

    public function accept(int $orderId)
    {
        $order = Order::where([
            'status' => OrderStatus::PENDING,
            'id'     => $orderId,
        ])->first();
        if (!blank($order)) {
            if ($order->payment_status == PaymentStatus::UNPAID) {
                $balance = Balance::find($order->user->balance_id);
                if (!blank($balance) && $balance->balance >= $order->total) {
                    $payment = app(TransactionService::class)->payment($order->user->balance_id, $this->adminBalanceId, $order->total, $orderId);
                    if ($payment->status) {
                        $order->payment_status = PaymentStatus::PAID;
                        $order->payment_method = PaymentMethod::WALLET;
                        $order->paid_amount    = $order->total;
                    }
                }
            }
            $order->status = OrderStatus::ACCEPT;
            $order->save();
            $orderHistory = $this->status($orderId, OrderStatus::ACCEPT);
            if ($orderHistory->status) {
                ResponseService::set(['order_history_id' => $orderHistory->order_history_id]);
            }
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'Order not found',
            ]);
        }
        return ResponseService::response();
    }

    public function reject(int $orderId)
    {
        $order = Order::where([
            'status' => OrderStatus::PENDING,
            'id'     => $orderId,
        ])->first();
        if (!blank($order)) {
            if ($order->payment_status == PaymentStatus::PAID && $order->payment_method != PaymentMethod::CASH_ON_DELIVERY) {
                $refund = app(TransactionService::class)->refund($this->adminBalanceId, $order->user->balance_id, $order->total, $orderId);
                if ($refund->status) {
                    $order->payment_status = PaymentStatus::UNPAID;
                    $order->payment_method = PaymentMethod::CASH_ON_DELIVERY;
                    $order->paid_amount    = 0;
                }
            }
            $order->status = OrderStatus::REJECT;
            $order->save();

            $couponStatus = Discount::where('order_id', $orderId)->first();
            if (!blank($couponStatus)) {
                $couponStatus->status = DiscountStatus::CANCELED;
            }

            $orderHistory = $this->status($orderId, OrderStatus::REJECT);
            if ($orderHistory->status) {
                ResponseService::set([
                    'order_history_id' => $orderHistory->order_history_id,
                ]);
            }
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'Order not found',
            ]);
        }
        return ResponseService::response();
    }

    public function cancel(int $orderId) // done
    {
        $order = Order::where([
            'status' => OrderStatus::PENDING,
            'id'     => $orderId,
        ])->first();
        if (!blank($order)) {
            if ($order->payment_status == PaymentStatus::PAID && $order->payment_method != PaymentMethod::CASH_ON_DELIVERY) {
                $refund = app(TransactionService::class)->refund($this->adminBalanceId, $order->user->balance_id, $order->total, $orderId);
                if ($refund->status) {
                    $order->payment_status = PaymentStatus::UNPAID;
                    $order->payment_method = PaymentMethod::CASH_ON_DELIVERY;
                    $order->paid_amount    = 0;
                }
            }
            $order->status = OrderStatus::CANCEL;
            $order->save();

            $couponStatus = Discount::where('order_id', $orderId)->first();
            if (!blank($couponStatus)) {
                $couponStatus->status = DiscountStatus::CANCELED;
            }

            $orderHistory = $this->status($orderId, OrderStatus::CANCEL);
            if ($orderHistory->status) {
                ResponseService::set([
                    'order_history_id' => $orderHistory->order_history_id,
                ]);
            }
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'Order not found',
            ]);
        }
        return ResponseService::response();
    }

    public function process(int $orderId) // done

    {
        $order = Order::where([
            'status' => OrderStatus::ACCEPT,
            'id'     => $orderId,
        ])->first();
        if (!blank($order)) {
            $order->status = OrderStatus::PROCESS;
            $order->save();
            $orderHistory = $this->status($orderId, OrderStatus::PROCESS);
            if ($orderHistory->status) {
                ResponseService::set(['order_history_id' => $orderHistory->order_history_id]);
            }
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'Order not found',
            ]);
        }
        return ResponseService::response();
    }

    public function completed(int $orderId) //done
    {
        $order = Order::orderowner()->findOrFail($orderId);
        if (!blank($order)) {
            if ($order->order_type == OrderTypeStatus::DELIVERY) {
                if ($order->payment_method == PaymentMethod::CASH_ON_DELIVERY && $order->payment_status == PaymentStatus::UNPAID) {
                    $addFund = app(TransactionService::class)->addFund(0, $order->user->balance_id, PaymentMethod::CASH_ON_DELIVERY, $order->total, $orderId);
                    if ($addFund->status) {
                        $payment = app(TransactionService::class)->payment($order->user->balance_id, $this->adminBalanceId, $order->total, $orderId);
                        if ($payment->status) {
                            $order->paid_amount    = $order->total;
                            $order->payment_status = PaymentStatus::PAID;
                        } else {
                            ResponseService::set([
                                'status'   => false,
                                'message'  => 'Payment does not complete',
                                'order_id' => $orderId,
                            ]);
                        }
                    }

                    $deliveryBoyAccount = DeliveryBoyAccount::where('user_id', $order->delivery_boy_id)->first();
                    if (!blank($deliveryBoyAccount)) {
                        $deliveryBoyAccount->delivery_charge = $deliveryBoyAccount->delivery_charge + $order->delivery_charge;
                        $deliveryBoyAccount->balance         = $deliveryBoyAccount->balance + $order->total;
                        $deliveryBoyAccount->save();
                    } else {
                        ResponseService::set([
                            'status'   => false,
                            'message'  => 'Delivery boy account does not found',
                            'order_id' => $orderId,
                        ]);
                    }
                } else {
                    $deliveryBoy = User::find($order->delivery_boy_id);
                    if (!blank($deliveryBoy)) {
                        $deliveryBoyBalanceId = $deliveryBoy->balance_id;
                        $amount               = $order->delivery_charge;
                        $transfer             = app(TransactionService::class)->transfer($this->adminBalanceId, $deliveryBoyBalanceId, $amount, $orderId);
                        if ($transfer->status) {
                            ResponseService::set([
                                'status'   => true,
                                'order_id' => $orderId,
                                'amount'   => $amount,
                            ]);
                        } else {
                            ResponseService::set([
                                'status'   => false,
                                'message'  => 'Delivery boy payment fail',
                                'order_id' => $orderId,
                                'amount'   => $amount,
                            ]);
                        }
                    } else {
                        ResponseService::set([
                            'status'   => false,
                            'message'  => 'Delivery boy not found',
                            'order_id' => $orderId,
                        ]);
                    }
                }
            } elseif ($order->order_type == OrderTypeStatus::PICKUP) {

                if ($order->payment_method == PaymentMethod::CASH_ON_DELIVERY && $order->payment_status == PaymentStatus::UNPAID) {
                    $addFund = app(TransactionService::class)->addFund(0, $order->user->balance_id, PaymentMethod::CASH_ON_DELIVERY, $order->total, $orderId);
                    if ($addFund->status) {
                        $payment = app(TransactionService::class)->payment($order->user->balance_id, 0, $order->total, $orderId);
                        if ($payment->status) {
                            $order->paid_amount    = $order->total;
                            $order->payment_status = PaymentStatus::PAID;

                            $restaurant          = Restaurant::find($order->restaurant_id);
                            $restaurantBalanceId = !blank($restaurant) ? $restaurant->user->balance_id : 0;
                            $amount              = ($order->sub_total / 100) * $this->commission;
                            $transfer            = app(TransactionService::class)->transfer($restaurantBalanceId, $this->adminBalanceId,  $amount, $orderId);
                        } else {
                            ResponseService::set([
                                'status'   => false,
                                'message'  => 'Payment does not complete',
                                'order_id' => $orderId,
                            ]);
                        }
                    }
                } else {
                    $restaurant          = Restaurant::find($order->restaurant_id);
                    $restaurantBalanceId = !blank($restaurant) ? $restaurant->user->balance_id : 0;
                    $amount              = ($order->sub_total - ($order->sub_total / 100) * $this->commission);
                    $transfer            = app(TransactionService::class)->transfer($this->adminBalanceId, $restaurantBalanceId, $amount, $orderId);
                }
            }


            $order->status = OrderStatus::COMPLETED;
            $order->save();

            $bestSelling = $this->bestSelling($orderId);
            if ($bestSelling->status) {
                ResponseService::set([
                    'status'   => true,
                    'order_id' => $orderId,
                ]);
            } else {
                ResponseService::set([
                    'status'   => false,
                    'message'  => $bestSelling->message,
                    'order_id' => $orderId,
                ]);
            }
            $orderHistory = $this->status($orderId, OrderStatus::COMPLETED);
            if ($orderHistory->status) {
                ResponseService::set([
                    'order_history_id' => $orderHistory->order_history_id,
                ]);
            }
        }
        return ResponseService::response();
    }

    public function productReceive(int $orderId, int $productReceiveStatus) // done
    {
        $order = Order::where([
            'status' => OrderStatus::PROCESS,
            'id'     => $orderId,
        ])->first();
        if (!blank($order)) {
            if ($productReceiveStatus == ProductReceiveStatus::RECEIVE) {
                $restaurant          = Restaurant::find($order->restaurant_id);
                $restaurantBalanceId = !blank($restaurant) ? $restaurant->user->balance_id : 0;
                $amount        = ($order->sub_total - ($order->sub_total / 100) * $this->commission);
                $transfer      = app(TransactionService::class)->transfer($this->adminBalanceId, $restaurantBalanceId, $amount, $orderId);

                if ($transfer->status) {
                    $order->status = OrderStatus::ON_THE_WAY;
                    $orderHistory  = $this->status($orderId, OrderStatus::ON_THE_WAY);
                    if ($orderHistory->status) {
                        ResponseService::set(['order_history_id' => $orderHistory->order_history_id]);
                    }
                }
            }
            $order->product_received = $productReceiveStatus;

            $order->save();
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'Order not found',
            ]);
        }
        return ResponseService::response();
    }

    public function status(int $orderId, int $status) // done
    {
        $orderHistory = OrderHistory::where(['order_id' => $orderId])->latest()->first();
        if (!blank($orderHistory)) {
            if ($orderHistory->current_status != $status) {
                $orderHistory = OrderHistory::create([
                    'order_id'        => $orderId,
                    'previous_status' => $orderHistory->current_status,
                    'current_status'  => $status,
                ]);
            }
        } else {
            $orderHistory = OrderHistory::create([
                'order_id'        => $orderId,
                'previous_status' => null,
                'current_status'  => OrderStatus::PENDING,
            ]);
            $orderHistory = OrderHistory::create([
                'order_id'        => $orderId,
                'previous_status' => $orderHistory->current_status,
                'current_status'  => $status,
            ]);
        }
        ResponseService::set([
            'status'           => true,
            'order_history_id' => $orderHistory->id,
        ]);
        return ResponseService::response();
    }

    public function bestSelling(int $orderId)
    {
        $orderItems = OrderLineItem::where(['order_id' => $orderId])->get();
        if (!blank($orderItems)) {
            foreach ($orderItems as $item) {
                $bestProduct = MenuItem::where([
                    'id' => $item->menu_item_id,
                    'restaurant_id'    => $item->restaurant_id,
                ])->first();
                if ($bestProduct) {
                    $bestProduct->counter = $bestProduct->counter + $item->quantity;
                    $bestProduct->save();
                }
                if (!blank($item->menuItem->categories)) {
                    foreach ($item->menuItem->categories as $category) {
                        $bestCategory = BestSellingCategory::where([
                            'category_id' => $category->id,
                            'restaurant_id'     => $item->restaurant_id,
                        ])->first();
                        if ($bestCategory) {
                            $bestCategory->counter = $bestCategory->counter + $item->quantity;
                            $bestCategory->save();
                        } else {
                            BestSellingCategory::create([
                                'category_id' => $category->id,
                                'restaurant_id'     => $item->restaurant_id,
                                'counter'     => $item->quantity,
                            ]);
                        }
                    }
                }
            }
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        }
        return ResponseService::response();
    }

    public function order($data): object
    {
        $address = "";
        $latitude = "";
        $longitude = "";
        if (isset($data['addressLabel'])) {
            if ($data['addressLabel'] == 'current') {
                $latitude = $data['lat'];
                $longitude = $data['long'];
                $address = json_encode([
                    'address' => $data['address'],
                    'apartment' => ""
                ]);
            } else {
                $address = Address::where('label_name', $data['addressLabel'])->first();
                $latitude = $address->latitude;
                $longitude = $address->longitude;
                $address = json_encode([
                    'address' => $address->address,
                    'apartment' => $address->apartment
                ]);
            }
        } else {
            if ($data['address'] == '') {
                $latitude = 0.0;
                $longitude = 0.0;
                $address = json_encode([
                    'address' => '',
                    'apartment' => ''
                ]);
            } else {
                $address = Address::find($data['address']);
                $latitude = $address->latitude;
                $longitude = $address->longitude;
                $address = json_encode([
                    'address' => $address->address,
                    'apartment' => $address->apartment
                ]);
            }
        }
        $time_slot_from_session = Session::get('time_slot');
        $order = [
            'user_id'         => $data['user_id'],
            'restaurant_id'   => $data['restaurant_id'],
            'total'           => $data['total'] + $data['delivery_charge'],
            'sub_total'       => $data['total'],
            'delivery_charge' => $data['delivery_charge'],
            'status'          => OrderStatus::PENDING,
            'order_type'      => $data['order_type'],
            'address'         => $address,
            'mobile'          => $data['mobile'],
            'time_slot'       => $time_slot_from_session ?? $data['time_slot'],
            'lat'             => $latitude,
            'long'            => $longitude,
            'misc'            => json_encode(["remarks" => '']),
            'payment_method'  => $data['payment_method'],
            'payment_status'  => $data['payment_status'],
            'paid_amount'     => $data['paid_amount'],
        ];

        if ($data['time_slot_tomorrow']) {
            $order['updated_at'] = Carbon::now()->addDay()->toDateTimeString();
        }

        $order   = Order::create($order);
        $orderId = $order->id;

        $this->giveReward($order->user_id);
//        $this->addLoyalty($order->user_id);

        OrderHistory::create([
            'order_id'        => $orderId,
            'previous_status' => null,
            'current_status'  => OrderStatus::PENDING,
        ]);


        if (!blank($data['coupon_id'])) {
            Discount::create([
                'order_id'  => $orderId,
                'coupon_id' => $data['coupon_id'],
                'amount'    => $data['coupon_amount'],
                'status'    => DiscountStatus::ACTIVE,
            ]);
        }

        if (!blank($data['items'])) {
            $i              = 0;
            $orderLineItems = [];
            foreach ($data['items'] as $item) {
                $optionTotal = 0;
                if (isset($item['options']) && !blank($item['options'])) {
                    foreach ($item['options'] as $option) {
                        $optionTotal += $option['price'];
                    }
                }
                // dd($item['options']);
                // INSERT INTO `order_line_items` (`id`, `order_id`, `restaurant_id`, `menu_item_id`, `quantity`, `unit_price`, `discounted_price`, `item_total`, `menu_item_variation_id`, `options`, `instructions`, `options_total`, `created_at`, `updated_at`) VALUES (NULL, '1', '1', '19', '1', '30.00', '0.00', '30.00', '4', '[]', NULL, '0', '2024-07-11 00:08:40', '2024-07-11 00:08:40');
                $orderLineItems[$i] = [
                    'order_id'                  => $orderId,
                    'restaurant_id'             => $item['restaurant_id'],
                    'menu_item_id'              => $item['menu_item_id'],
                    'quantity'                  => $item['quantity'],
                    'unit_price'                => $item['unit_price'],
                    'discounted_price'          => $item['discounted_price'],
                    'item_total'                => ($item['unit_price'] * $item['quantity']),
                    'menu_item_variation_id' => $item['menu_item_variation_id'],
                    'options'                   => json_encode($item['options']),
                    'instructions'              => $item['instructions'],
                    'options_total'             => $optionTotal,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
                $i++;
            }

            //dd($orderLineItems);
            OrderLineItem::insert($orderLineItems);
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
            ]);
        } else {
            ResponseService::set(['message' => 'Items not found']);
        }

        $order       = Order::findOrFail($orderId);
        $order->misc = json_encode([
            'order_code' => 'ORD-' . MyString::code($orderId),
            'remarks'    => isset($data['remarks']) ? $data['remarks'] : '',
        ]);
        $order->save();
        if ($data['payment_status'] == PaymentStatus::PAID) {
            if ($data['payment_method'] != PaymentMethod::WALLET) {
                $addFund = app(TransactionService::class)->addFund(0, $order->user->balance_id, $data['payment_method'], $order->total, $orderId);
            }

            if ($this->adminBalanceId != $order->user->balance_id) {
                app(TransactionService::class)->payment($order->user->balance_id, $this->adminBalanceId, $order->total, $orderId);
            }
        }

//        $order = Order::first();

        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            array('cluster' => config('broadcasting.connections.pusher.options.cluster'))
        );

        $channels = 'orders';
        $event = 'App\\Events\\OrderReceived';
        $data = json_encode(['order' => $order]);

        $response = $pusher->trigger($channels, $event, $data);
//        event(new OrderReceived('Hello'));

        return ResponseService::response();
    }

    public function orderUpdate(int $orderId, int $status)
    {
        $orderStatus = (object) [
            'status'  => false,
            'message' => 'Not found',
        ];
        if ($status == OrderStatus::ACCEPT) {
            $orderStatus = $this->accept($orderId);
        } elseif ($status == OrderStatus::REJECT) {
            $orderStatus = $this->reject($orderId);
        } elseif ($status == OrderStatus::CANCEL) {
            $orderStatus = $this->cancel($orderId);
        } elseif ($status == OrderStatus::PROCESS) {
            $orderStatus = $this->process($orderId);
        } elseif ($status == OrderStatus::COMPLETED) {
            $orderStatus = $this->completed($orderId);
        }

        if ($orderStatus->status) {
            ResponseService::set([
                'status'           => $orderStatus->status,
                'order_id'         => $orderStatus->order_id,
                'order_history_id' => $orderStatus->order_history_id,
            ]);
        }
        return ResponseService::response();
    }

    public function giveReward($userId)
    {
        $redeem_setting = RedeemSetting::first();
        $status = $redeem_setting->status;
        $score_value = $redeem_setting->score_value;
        $reward_value = $redeem_setting->reward_value;
        $reward_menu_item_id = $redeem_setting->reward_menu_item_id;

        $loyalty_id = LoyaltyScore::updateOrCreate(
            ['customer_id' => $userId],
            ['customer_id' => $userId]
        )->increment('score', $score_value);

        $loyalty = LoyaltyScore::find($loyalty_id);

        if ($status == 1 && $loyalty->score >= $reward_value) {

//            LoyaltyUser::create([
//                'customer_id' => $userId,
//                'scores' => $loyalty->score,
//            ]);
            // give reward
//            OrderLineItem::create([
//                'order_id' => null,
//                'restaurant_id' => null,
//                'menu_item_id' => $reward_menu_item_id,
//                'quantity' => 1,
//                'unit_price' => 0,
//                'discounted_price' => 0,
//                'item_total' => 0,
//                'menu_item_variation_id' => null,
//                'options' => json_encode([]),
//                'instructions' => null,
//                'options_total' => 0,
//                'created_at' => date('Y-m-d H:i:s'),
//                'updated_at' => date('Y-m-d H:i:s'),
//            ]);
            $total = 0;

            $menu_item = MenuItem::find($reward_menu_item_id);

            if  (blank($menu_item)) {
                return;
            }

            $total += $menu_item->unit_price;

            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
                'sub_total' => $total,
                'paid_amount' => 0,
                'status' => OrderStatus::PENDING,
                'restaurant_id' => Restaurant::query()->first()->id
            ]);

            $order_id = $order->id;

            $order->misc = json_encode([
                'order_code' => 'ORD-' . MyString::code($order_id),
                'remarks'    => 'Rewarded Order',
            ]);
            $order->save();


//            foreach ($reward->menuItems as $menu) {
//
//                $menus[] = ['menu_item_id' => $menu->id, 'order_id' => $order_id, 'quantity' => 1, 'unit_price' => $menu->unit_price, 'item_total' => $menu->unit_price];
//            }

            $menu = [
                'menu_item_id' => $menu_item->id,
                'order_id' => $order_id,
                'quantity' => 1,
                'unit_price' => $menu_item->unit_price,
                'item_total' => $menu_item->unit_price,
                'instructions' => 'This is a Rewarded 100% Free Gift Order.',
            ];


            OrderLineItem::insert($menu);

            $loyalty->update([
                'score' => 0
            ]);
        }
    }

    public function addLoyalty($userId)
    {
        $redeem_setting = RedeemSetting::first();
        $score_value = $redeem_setting->score_value;
        $reward_value = $redeem_setting->reward_value;

        $loyalty_id = LoyaltyScore::updateOrCreate(
            ['customer_id' => $userId],
            ['customer_id' => $userId]
        )->increment('score', $score_value);

        $loyalty = LoyaltyScore::find($loyalty_id);

        if ($loyalty->score >= $reward_value) {

            LoyaltyUser::create([
                'customer_id' => $userId,
                'scores' => $loyalty->score,
            ]);

            $loyalty->update([
                'score' => 0
            ]);
        }
    }
}
