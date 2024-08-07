<?php

namespace App\Livewire;

use App\Enums\DeliveryStatus;
use App\Enums\RestaurantStatus;
use App\Http\Services\RestaurantService;
use App\Models\Coupon;
use App\Models\Restaurant;
use Livewire\Component;
use App\Enums\CouponType;
use App\Enums\DiscountStatus;
use App\Enums\DiscountType;
use App\Models\Discount;
use App\Enums\DeliveryType;

class OrderCart extends Component
{
    public $carts = [];
    public $totalQty = 0;
    public $totalItem = 0;
    public $totalAmount = 0;
    public $subTotalAmount = 0;
    public $delivery_charge = 0;
    public $totalPayAmount = 0;
    public $restaurant;
    public $time_slots;
    public $time_slot;
    public $totalItemQtyAmount;
    public $totalItemQty;
    public $qty = 1;
    public $coupon = '';
    public $discountAmount = 0;
    public $min_order = 0;
    public $max_order = 0;
    public $msg = '';
    public $couponID = 0;
    public $delivery_type;
    public $free_delivery;
    public bool $isActive = false;
    public bool $isActiveCheckout = true;

    protected $listeners = ['addCart'];

    public function __construct()
    {
        $this->isActive = session()->get('is_pickup') ?? false;
    }

    public function mount()
    {
//        dd(session('session_cart_restaurant_id'));
        $this->restaurant = Restaurant::find(session('session_cart_restaurant_id'));
        if(!isset($this->restaurant)){
            $this->restaurant = Restaurant::where('status', RestaurantStatus::ACTIVE)->first();
        }
        if(isset($this->restaurant)){
            if ($this->restaurant->pickup_status == DeliveryStatus::ENABLE && $this->restaurant->delivery_status == DeliveryStatus::DISABLE) {
                $this->delivery_charge = 0;
                $this->delivery_type = true;
            } elseif ($this->restaurant->pickup_status == DeliveryStatus::DISABLE && $this->restaurant->delivery_status == DeliveryStatus::DISABLE){
                $this->isActiveCheckout = false;
            }

            $this->time_slots = RestaurantService::timeSlots($this->restaurant);
        }


        $this->carts = session()->get('cart');
        if (!blank($this->carts)) {
            $this->totalCartAmount();
        }
    }

    public function isUpdating()
    {
        $this->delivery_type = $this->isActive;
        if (!blank($this->carts)) {
            $this->totalCartAmount();
        }

        // check if $restaurant->lowestDeliveryCharge->min_order <= $subTotalAmount
//        if ($this->restaurant->lowestDeliveryCharge->min_order <= $this->subTotalAmount) {
//            $this->isActiveCheckout = false;
//        }
    }

    public function changeTimeSlot()
    {
        session()->put('session_cart_time_slot', $this->time_slot);
    }

    public function render()
    {
        return view('livewire.order-cart');
    }

    public function addCart($item)
    {

        $status = true;
        if (!blank($this->carts) && count($this->carts['items']) != 0) {
            foreach ($this->carts['items'] as $key => $cart) {
                if ($item['id'] == $this->carts['items'][$key]['id'] && $item['variations'] == $this->carts['items'][$key]['variations']) {
                    $this->carts['items'][$key]['qty'] += $item['qty'];
                    $status = false;
                } elseif ($item['id'] == $this->carts['items'][$key]['id']) {
                    $this->carts['items'][$key]['qty'] += $item['qty'];
                    $status = false;
                }
            }
        }
        if ($status) {
            $this->carts['items'][] = $item;
        }


        $this->totalCartAmount();
    }

    public function changeEvent($id)
    {
        if ($this->carts['items'][$id]['qty'] != '' && $this->carts['items'][$id]['qty'] != 0) {
            $this->totalCartAmount();
        }
    }
    public function addItemQty($id)
    {
        $this->carts['items'][$id]['qty']++;
        $this->addCoupon();
        $this->totalCartAmount();
    }
    public function removeItemQty($id)
    {
        if (!blank($this->carts['items'])) {
            $this->carts['items'][$id]['qty']--;
            if ($this->carts['items'][$id]['qty'] == 0) {
                unset($this->carts['items'][$id]);
                $this->carts['items'] = array_values($this->carts['items']);
            }
        }
        $this->totalCartAmount();

    }


    public function totalCartAmount()
    {
        $this->totalItem = 0;
        $this->totalAmount = 0;
        $this->totalQty = 0;
        $this->subTotalAmount = 0;
        if (!blank($this->carts['items'])) {
            foreach ($this->carts['items'] as $key => $cart) {
                $this->totalItem += 1;
                $this->totalQty += $cart['qty'];
                $this->totalAmount += $cart['price'] * $cart['qty'];
                $this->carts['items'][$key]['totalPrice'] =  $cart['price'] * $cart['qty'];
                $this->delivery_charge = setting('basic_delivery_charge');
            }

            if ($this->delivery_type == DeliveryType::PICKUP) {
                $this->delivery_charge = 0;
                $this->delivery_type = true;
            }
            $this->carts['couponID'] = $this->couponID;
            $this->subTotalAmount = $this->totalAmount;
            $this->carts['subTotalAmount'] = $this->totalAmount;
            $this->totalAmount  = $this->totalAmount - $this->discountAmount;
            $this->carts['totalQty'] = $this->totalQty;

            $this->carts['totalPayAmount'] = $this->totalAmount + $this->delivery_charge;
            $this->carts['totalAmount'] = $this->totalAmount;
            $this->carts['delivery_charge'] = $this->delivery_charge;


            $this->carts['min_order'] = $this->min_order;
            $this->carts['max_order'] = $this->max_order;
            $this->carts['coupon_amount'] = $this->discountAmount;
            $this->carts['delivery_type'] = $this->delivery_type;
            $this->carts['free_delivery'] = $this->free_delivery;
            $this->totalPayAmount = $this->totalAmount + $this->delivery_charge;
        } else {
            $this->totalAmount = 0;
            $this->delivery_charge = 0;
            $this->delivery_type = false;
            $this->free_delivery = false;
            $this->min_order = 0;
            $this->max_order = 0;
            $this->totalPayAmount = 0;
            $this->subTotalAmount = 0;
            $this->carts['couponID'] = 0;
            $this->carts['subTotalAmount'] = 0;
            $this->carts['totalQty'] = 0;
            $this->carts['totalPayAmount'] = 0;
            $this->carts['totalAmount'] = 0;
            $this->carts['delivery_charge'] = 0;
            $this->carts['coupon_amount'] = 0;
        }

        $this->dispatch('showCartQty', ['qty' => $this->totalQty]);

        session()->put('cart', $this->carts);
        $this->carts = session()->get('cart');
    }

    public function removeItem($id)
    {
        unset($this->carts['items'][$id]);
        session()->put('cart', $this->carts);
        $this->totalCartAmount();
    }

    public function addCoupon()
    {
        if (!blank($this->coupon)) {
            $this->msg = '';
            $today = date('Y-m-d h:i:s');
            $total_amount = $this->carts['totalAmount'];
            $restaurant_id = session()->get('session_cart_restaurant_id');
            $coupon = Coupon::where('slug', $this->coupon)->first();

            if (!blank($coupon)) {
                $total_used = Discount::where('coupon_id', $coupon->id)->where('status', DiscountStatus::ACTIVE)->count();
                $user_limit = Discount::where(['coupon_id' => $coupon->id, 'user_id' => auth()->user()->id ?? 0])->where('status', DiscountStatus::ACTIVE)->count();
            }

            if (blank($coupon)) {
                $this->msg = 'This Coupon is Invalid';
            } elseif ($coupon->coupon_type == CouponType::VOUCHER && $coupon->restaurant_id != $restaurant_id) {
                $this->msg = 'This Coupon is Invalid';
            } elseif ($total_used >= $coupon->limit) {
                $this->msg = 'This Coupon is Expired';
            } elseif (!(($coupon->to_date >= $today) && ($coupon->from_date <= $today))) {
                $this->msg = 'This Coupon is Expired';
            } elseif ($user_limit >= $coupon->user_limit) {
                $this->msg = 'This Coupon is Expired';
            } elseif ($total_amount < $coupon->minimum_order_amount) {
                $this->msg = 'Minimum Order Amount for This Coupon is ' . currencyFormat($coupon->minimum_order_amount);
            } else {
                $this->msg = '';
            }
            if (blank($this->msg)) {
                $this->msg = '';
                $this->couponID = $coupon->id;
                if ($coupon->discount_type == DiscountType::FIXED) {
                    $discount = round($coupon->amount);
                } else {
                    $discount = round(($total_amount * $coupon->amount) / 100);
                }

                $this->discountAmount = $discount;
                $this->totalCartAmount();
            } else {
                $this->discountAmount = 0;
                $this->couponID = 0;
                $this->totalCartAmount();
            }
        }
    }
}
