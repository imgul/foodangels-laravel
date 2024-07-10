<?php
namespace App\Livewire;

use App\Enums\Status;
use App\Models\MenuItem;
use App\Models\MenuItemOption;
use App\Models\MenuItemType;
use App\Models\MenuItemVariation;
use App\Models\PromotionMenus;
use App\Models\RestaurantPostalCode;
use Livewire\Component;

class ShowCart extends Component
{
    public $restaurant,
        $menuItem,
        $quantity = 1,
        $menu_id,
        $restaurant_id,
        $variationID,
        $options = [],
        $instructions,
        $price = false;

    public $index = 0;
    public $variations = [];
    public $variationsType = [];
    public $variationOptionsProductInfo;
    public $productInfo;
    public $promoPrice = 0;
    public $promoId = 0;
    public $menuItemTypes = [];
    public $menuItemVariations = [];
    public $menuItemOptions = [];
    public $cartPrice = 0;

    protected $listeners = ['CartModal'];

    public function addItemQty()
    {
        $this->quantity++;
    }

    public function removeItemQty()
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function submit($restaurant_id, $menu_id)
    {
        session()->put('session_cart_restaurant_id', $restaurant_id);
        session()->put('session_cart_restaurant', $this->restaurant->slug);

        $allpromottedMenus = PromotionMenus::with('promo')->where('restaurant_id', $restaurant_id)->where('menu_id',$menu_id)->first();


        $this->promoPrice = $this->menuItem->unit_price - $this->menuItem->discount_price;
        //   echo"<pre>"; print_r($allpromottedMenus); die;
        if (isset($allpromottedMenus) && $allpromottedMenus->promo->status ==5) {
            $this->promoPrice = promoPrice($this->menuItem->unit_price, $this->menuItem->discount_price, $allpromottedMenus->promo->amount);
            $this->promoId = $allpromottedMenus->promo->id;

        }

        $this->restaurant_id = $restaurant_id;
        $this->menu_id = $menu_id;
        session()->put('session_cart_restaurant_id', $restaurant_id);
        session()->put('session_cart_restaurant', $this->restaurant->slug);
        $totalPrice = $this->promoPrice;
        $discount   = $this->menuItem->discount_price;
        $variationArray = [];
        if (!blank($this->variations)) {
            $variations = MenuItemVariation::whereIn('id', $this->variations)->get();
            $j = 0;
            // echo "<pre>"; print_r($variations); die;
            foreach ($variations as $variation) {

                if ($variation->type == 0) {
                    $variationArray[$j]['id'] = $variation->id;
                    $variationArray[$j]['name'] = $variation->name;
                    $variationArray[$j]['price'] = $variation->unit_price;
                } else {
                    $variationArray[$j]['id'] = $variation->id;
                    $variationArray[$j]['name'] = $variation->relatedmenuitem->name;
                    $variationArray[$j]['price'] = $variation->relatedmenuitem->unit_price;
                }

                if ($variation->unit_price) {
                    if ($variation->menu_item_type_id ==13) {
                        $totalPrice = $variation->unit_price;
                    }
                    else{
                        $totalPrice += $variation->unit_price;
                    }
                    // $totalPrice += $variation->unit_price;
                } elseif (!blank($variation->relatedmenuitem)) {
                    $totalPrice += $variation->relatedmenuitem->unit_price;
                }
                $j++;
            }
        }
        // else{

        //     $ijs_menuItemTypes        = MenuItemType::where('status', Status::ACTIVE)->orderBy('id','desc')->get();

        //     $ijs_menuItemVariations   = $this->menuItem->variations->groupBy('menu_item_type_id')->toBase();

        //     //---------------

        //     $tmp_variation = array();
        //         if(!blank($ijs_menuItemTypes)){
        //             foreach(MenuItemType::where('status', Status::ACTIVE)->orderBy('id','desc')->get() as $type){
        //                 if(isset($ijs_menuItemVariations[$type->id]))
        //                 {
        //                     $io=1;
        //                     foreach($ijs_menuItemVariations[$type->id] as $variation)
        //                     {
        //                         if($io==1){
        //                             if($variation['type'] == 0){
        //                                 array_push($tmp_variation, $variation['id']);

        //                             }
        //                         }

        //                         $io++;
        //                     }


        //                  }

        //             }
        //         }
        //         if (!blank($tmp_variation)) {
        //             $variations = MenuItemVariation::whereIn('id', $tmp_variation)->get();
        //             $j = 0;
        //             foreach ($variations as $variation) {

        //                 if ($variation->type == 0) {
        //                     $variationArray[$j]['id'] = $variation->id;
        //                     $variationArray[$j]['name'] = $variation->name;
        //                     $variationArray[$j]['price'] = $variation->unit_price;
        //                 } else {
        //                     $variationArray[$j]['id'] = $variation->id;
        //                     $variationArray[$j]['name'] = $variation->relatedmenuitem->name;
        //                     $variationArray[$j]['price'] = $variation->relatedmenuitem->unit_price;
        //                 }

        //                 if ($variation->unit_price) {
        //                     $totalPrice += $variation->unit_price;
        //                 } elseif (!blank($variation->relatedmenuitem)) {
        //                     $totalPrice += $variation->relatedmenuitem->unit_price;
        //                 }
        //                 $j++;
        //             }
        //         }
        //     //---------------
        //     //print_r($smenuItemVariations); die;
        // }
        $optionArray = [];
        if (!blank($this->options)) {
            $options = MenuItemOption::whereIn('id', $this->options)->get();
            $i       = 0;
            foreach ($options as $option) {
                if ($option->type == 0) {
                    $optionArray[$i]['id'] = $option->id;
                    $optionArray[$i]['name'] = $option->name;
                    $optionArray[$i]['price'] = $option->unit_price;
                } else {
                    $optionArray[$i]['id'] = $option->id;
                    $optionArray[$i]['name'] = $option->relatedmenuitem->name;
                    $optionArray[$i]['price'] = $option->relatedmenuitem->unit_price;
                }
                if ($option->unit_price) {

                    $totalPrice += $option->unit_price;
                } elseif (!blank($option->relatedmenuitem)) {
                    $totalPrice += $option->relatedmenuitem->unit_price;
                }
                $i++;
            }
        }
        $instructions = !blank($this->instructions) ? $this->instructions : "";
        $test = session()->get('session_'.$menu_id, []);
        $test[0] = $instructions;
        session()->put('session_'.$menu_id, $test);
        $getInstruction = session()->get('session_'.$menu_id, []);

        $sessionRestaurantId = $this->menuItem->restaurant_id;
        $postCode = session()->get('postal_code');

        $RestaurantPostalCode = RestaurantPostalCode::where(['postal_code'=>$postCode,'restaurant_id'=>$sessionRestaurantId])->first();
        // dd($RestaurantPostalCode);
        if($RestaurantPostalCode){
            $delivery_charge = $RestaurantPostalCode->delivery_charge;
            $min_order = $RestaurantPostalCode->min_order;
            $max_order = $RestaurantPostalCode->max_order;
        }elseif ($this->restaurant->postalCode()){
            $delivery_charge = $this->restaurant->postalCode()->delivery_charge;
            $min_order = $this->restaurant->postalCode()->min_order;
            $max_order = $this->restaurant->postalCode()->max_order;
        }
        $cartItem = [
            'id'              => $menu_id,
            'name'            => $this->menuItem->name,
            'qty'             => $this->quantity,
            'price'           => $totalPrice,
            'delivery_charge' => $delivery_charge,
            'min_order'       => $min_order,
            'max_order'       => $max_order,
            'options'         => $optionArray,
            'variations'       => $variationArray,
            'discount'        => $discount,
            'restaurant_id'       => $this->menuItem->restaurant_id,
            'images'          => $this->menuItem->images,
            'menuItem_id'     => $this->menuItem->id,
            'instructions'    => $getInstruction,
            'promoId'=>$this->promoId,
        ];
        //   echo "<pre>"; print_r($cartItem); die;
//        $this->emit('addCart', $cartItem);
        $this->dispatch('addCart', $cartItem);
        $this->resetFields();
    }

    public function submitOld($restaurant_id, $menu_id)
    {

        session()->put('session_cart_restaurant_id', $restaurant_id);
        session()->put('session_cart_restaurant', $this->restaurant->slug);

        $variationArray = $optionArray = [];
        $variationId = $totalPrice = $discount = null;


        if ((int)$this->variationID) {

            $variation = MenuItemVariation::find($this->variationID);
            $this->setVariationData($variation, $variationArray, $variationId, $totalPrice, $discount);
        } else {
            $totalPrice = $this->menuItem->unit_price - $this->menuItem->discount_price;
            $discount = $this->menuItem->discount_price;
        }

        if (!blank($this->options)) {
            $this->setOptionData($optionArray, $totalPrice);
        }

        $instructions = !blank($this->instructions) ? $this->instructions : "";

        $cartItem = [
            'id'              => $menu_id,
            'name'            => $this->menuItem->name,
            'qty'             => $this->quantity,
            'price'           => $this->price ?: $totalPrice,
            'delivery_charge' => $this->restaurant->delivery_charge,
            'options'         => $optionArray,
            'variation'       => $variationArray,
            'discount'        => $discount,
            'restaurant_id'   => $this->menuItem->restaurant_id,
            'images'          => $this->menuItem->images,
            'menuItem_id'     => $this->menuItem->id,
            'variationID'     => $variationId,
            'instructions'    => $instructions,
        ];

        $this->dispatch('addCart', $cartItem);
        $this->resetFields();
    }

    public function CartModal($itemID, $price)
    {
//        $this->resetFields();
//        $this->menuItem = MenuItem::with('variations')->with('options')->where('id', $itemID)->first();
//        if (!blank($this->menuItem->variations)) {
//            $this->variationID = $this->menuItem->variations->first()->id;
//        }
//        $this->price = $price;

        $this->quantity = 1;
        $this->instructions = '';
        $this->variationID = null;
        $this->options = [];

        $this->index = 0;
        $this->variations = [];
        $this->variationsType = [];
        $this->promoPrice = 0;
        $this->options = [];
        $this->menuItemVariations = [];
        $this->menuItemOptions = [];
        $this->menuItem = null;
        $this->productInfo          = MenuItem::where('id', $itemID)->first();
        $this->menuItem             = MenuItem::with('variations')->with('options')->where(['id' => $itemID])->first();
        $this->menuItemVariations   = $this->menuItem->variations->groupBy('menu_item_type_id')->toBase();
        $this->menuItemOptions      = $this->menuItem->options->groupBy('menu_item_type_id')->toBase();
        $this->menuItemTypes        = MenuItemType::where('status', Status::ACTIVE)->orderBy('id','desc')->get();
        if ($price > 0) {
            $this->promoPrice = $price;
        } else {
            $this->promoPrice  = $this->menuItem->unit_price - $this->menuItem->discount_price;
        }
        $this->cartPrice = $this->promoPrice;
//        $this->price = $this->promoPrice;
    }

    private function setVariationData($variation, &$variationArray, &$variationId, &$totalPrice, &$discount)
    {
        $variationArray = [
            'id'    => $variation->id,
            'name'  => $variation->name,
            'price' => $variation->price - $variation->discount_price,
        ];

        $variationId = $variation->id;
        $totalPrice  = $variationArray['price'];
        $discount    = $variation->discount_price;
    }

    private function setOptionData(&$optionArray, &$totalPrice)
    {
        $options = MenuItemOption::whereIn('id', $this->options)->get();
        foreach ($options as $option) {
            $optionArray[] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price,
            ];
            $totalPrice += $option->price;
        }
    }

    private function resetFields()
    {
        $this->quantity = 1;
        $this->instructions = '';
        $this->variationID = null;
        $this->options = [];
        $this->dispatch('closeFormModalCart');
    }

    public function render()
    {
        if ($this->menuItem) {
            $this->productInfo          = MenuItem::where('id', $this->menuItem->id)->first();
            $this->menuItem             = MenuItem::with('variations')->with('options')->where(['id' => $this->menuItem->id])->first();
            $this->menuItemVariations   = $this->menuItem->variations->groupBy('menu_item_type_id')->toBase();
            $this->menuItemOptions      = $this->menuItem->options->groupBy('menu_item_type_id')->toBase();
            $this->menuItemTypes        = MenuItemType::where('status', Status::ACTIVE)->get();

            $totalPrice = 0;
            $totalOptionPrice = 0;
            $this->variations = [];

            if(!blank($this->variationsType)) {
                foreach ($this->variationsType as  $variationType) {
                    if($variationType !='') {
                        $this->variations[] = $variationType;
                    }
                }
            }
            if (!blank($this->variations)) {
                $variations = MenuItemVariation::whereIn('id', $this->variations)->get();

                foreach ($variations as $variation) {



                    if ($variation->unit_price) {
                        if ($variation->menu_item_type_id ==13) {
                            $this->promoPrice = $variation->unit_price;
//                            $this->price = $variation->unit_price;
                        }
                        else{
                            $totalPrice += $variation->unit_price;
                        }
                    } elseif (!blank($variation->relatedmenuitem)) {
                        $totalPrice += $variation->relatedmenuitem->unit_price;
                    }

                }
            }
            if (!blank($this->options)) {
                $options = MenuItemOption::whereIn('id', $this->options)->get();
                foreach ($options as $option){
                    if($option->unit_price){
                        $totalOptionPrice += $option->unit_price;
                    }elseif (!blank($option->relatedmenuitem)) {
                        $totalOptionPrice += $option->relatedmenuitem->unit_price;
                    }
                }
            }
            $this->cartPrice = ($this->promoPrice + $totalOptionPrice + $totalPrice) * $this->quantity;
        }

        return view('livewire.show-cart');
    }

    public function mountOld()
    {
        return view('livewire.show-cart');
    }

    public function changeVariation($value,$typeID)
    {
        $this->variations = [];
        $this->variationsType[$typeID] = $value;
    }
}
