<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MenuItem;
use App\Enums\MenuItemStatus;
use App\Models\PromotionMenus;

class ShowPromoInfo extends Component
{
    public $promottedMenus = [];
    public $relatedPromo = [];
    public $restaurant;
    public $menu_item;
    public $menu_id = 0;
    public $variations;
    public $options;
    public $instructions;
    public $quantity=1;
    public $restaurant_id;
    public $product_categories;
    public $other_products;

    public function addToCartPromoModal($itemID,$promoPrice)
    {
//        dd($itemID, $promoPrice);

        $this->dispatch('CartModal',$itemID,$promoPrice);
        $this->dispatch('openFormModalCart');
    }
    public function addToInfoModal($itemID){
        $this->emit('infoModal',$itemID);
        $this->dispatchBrowserEvent('openFormInfoModal');
    }
    public function render()
    {
         $this->promottedMenus=[];

        $this->promottedMenus = PromotionMenus::with(['promo','product'])->where('restaurant_id', $this->restaurant->id)->orWhere('restaurant_id', 0)->get();

        return view('livewire.show-promo-info');

    }
}
