<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\MenuItemVariation;

class MenuItemVariationsSeeder extends Seeder
{
    public array $menuItemVariations = [
        [
            "menu_item_id" => 1,
            "restaurant_id" => 2,
            "name" => "Pepsi Cherry Pepsi®",
            "unit_price" => "6.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 1,
            "restaurant_id" => 2,
            "name" => "Medium Cherry Pepsi®",
            "unit_price" => "6.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 1,
            "restaurant_id" => 2,
            "name" => "Pepsi Cherry Pepsi®",
            "unit_price" => "6.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 19,
            "restaurant_id" => 1,
            "name" => "Small",
            "unit_price" => "30.00",
            "discount_unit_price" => "10.00",
        ],
        [
            "menu_item_id" => 3,
            "restaurant_id" => 2,
            "name" => "Half",
            "unit_price" => "5.20",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 3,
            "restaurant_id" => 2,
            "name" => "Medium",
            "unit_price" => "6.20",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 3,
            "restaurant_id" => 2,
            "name" => "Full",
            "unit_price" => "8.20",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 23,
            "restaurant_id" => 3,
            "name" => "Short Pumpkin Spice Latte",
            "unit_price" => "6.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 23,
            "restaurant_id" => 3,
            "name" => "Tall Pumpkin Spice Latte",
            "unit_price" => "6.75",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 23,
            "restaurant_id" => 3,
            "name" => "Grande Pumpkin Spice Latte",
            "unit_price" => "7.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 24,
            "restaurant_id" => 3,
            "name" => "Short Caffè Americano",
            "unit_price" => "5.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 24,
            "restaurant_id" => 3,
            "name" => "Tall Caffè Americano",
            "unit_price" => "5.50",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 24,
            "restaurant_id" => 3,
            "name" => "Grande Caffè Americano",
            "unit_price" => "6.50",
            "discount_unit_price" => "0.00",
        ],

        [
            "menu_item_id" => 56,
            "restaurant_id" => 1,
            "name" => "1kg",
            "unit_price" => "20.00",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 56,
            "restaurant_id" => 1,
            "name" => "2kg",
            "unit_price" => "35.00",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 19,
            "restaurant_id" => 1,
            "name" => "Medium",
            "unit_price" => "40.00",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 25,
            "restaurant_id" => 1,
            "name" => "Small",
            "unit_price" => "35.00",
            "discount_unit_price" => "2.00",
        ],
        [
            "menu_item_id" => 25,
            "restaurant_id" => 1,
            "name" => "Medium",
            "unit_price" => "44.00",
            "discount_unit_price" => "3.00",
        ],
        [
            "menu_item_id" => 25,
            "restaurant_id" => 1,
            "name" => "Large",
            "unit_price" => "57.00",
            "discount_unit_price" => "3.00",
        ],
        [
            "menu_item_id" => 34,
            "restaurant_id" => 1,
            "name" => "Small",
            "unit_price" => "40.00",
            "discount_unit_price" => "30.00",
        ],
        [
            "menu_item_id" => 34,
            "restaurant_id" => 1,
            "name" => "Medium",
            "unit_price" => "55.00",
            "discount_unit_price" => "50.00",
        ],
        [
            "menu_item_id" => 34,
            "restaurant_id" => 1,
            "name" => "Large",
            "unit_price" => "65.00",
            "discount_unit_price" => "60.00",
        ],
        [
            "menu_item_id" => 44,
            "restaurant_id" => 1,
            "name" => "Small",
            "unit_price" => "33.00",
            "discount_unit_price" => "0.00",
        ],
        [
            "menu_item_id" => 44,
            "restaurant_id" => 1,
            "name" => "Large",
            "unit_price" => "54.00",
            "discount_unit_price" => "0.00",
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->menuItemVariations as $menuItemVariation) {
                MenuItemVariation::create([
                    'menu_item_id'  => $menuItemVariation['menu_item_id'],
                    'restaurant_id' => $menuItemVariation['restaurant_id'],
                    'name'          => $menuItemVariation['name'],
                    'unit_price'    => $menuItemVariation['unit_price'],
                ]);
            }
        }
    }
}
