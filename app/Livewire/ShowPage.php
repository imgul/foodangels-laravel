<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Component;

class ShowPage extends Component
{
    public $categories_products = [];
    public $categories = [];
    public $other_products;
    public $restaurant;
    public $ordered_categories;
    public $menu_item;
    public $menu_id = 0;
    public $variations;
    public $options;
    public $instructions;
    public $quantity=1;
    public $restaurant_id;

    public function addToCartModal($itemID, $promoPrice)
    {
        $this->dispatch('CartModal', $itemID, $promoPrice);
        $this->dispatch('openFormModalCart');
    }

    public function mount()
    {
        $products = MenuItem::with('categories_orderBy')->with('categories')->with('media')->with('variations')->with('options')->where(['restaurant_id' => $this->restaurant->id])->get();
        foreach($products as $key => $product) {
            $product_categories = $product->categories_orderBy;
            if(!blank($product_categories)) {
                foreach($product_categories as $product_category) {
                    $this->categories[$product_category->id]            = $product_category;
                    $this->categories_products[$product_category->id][$key] = $product;
                    $this->categories_products[$product_category->id][$key]['image'] = $product->image;
                }
            } else {
                $this->other_products[$key] = $product;
                $this->other_products[$key]['image'] = $product->image;
            }
        }
//        usort($this->categories, function($a, $b) {
//            return $a->orders - $b->orders;
//        });

//        usort($this->categories_products, function($a, $b) {
//            return $a->order - $b->order;
//        });

//        dd($this->categories, $this->categories_products);
        return view('livewire.show-page');
    }
}
