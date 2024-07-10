<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\MenuItemType;
use Illuminate\Database\Seeder;
use App\Models\MenuItemOption;

class MenuItemsTypeSeeder extends Seeder
{
    public array $menuItemOptions = [
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Soft Drink",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Guacamole",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Borhani",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Small 250ml",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Medium 500ml",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Large 1000ml",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Coke 250ml",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Pepsi",
            "status"         => Status::ACTIVE,
        ],

        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Souce",
            "status"         => Status::ACTIVE,
        ],
        [
            "menu_item_id"  => 34,
            "restaurant_id" => 1,
            "name"          => "Drinks",
            "status"         => Status::ACTIVE,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->menuItemOptions as $menuItemOption) {
                MenuItemType::create([
                    'name'          => $menuItemOption['name'],
                    'status'         => $menuItemOption['status'],
                ]);
            }
        }
    }
}
