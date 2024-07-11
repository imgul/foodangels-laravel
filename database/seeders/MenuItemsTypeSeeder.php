<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\MenuItemType;
use Illuminate\Database\Seeder;
use App\Models\MenuItemOption;

class MenuItemsTypeSeeder extends Seeder
{


    public array $menuItemOptions = array(
        array('id' => '1','name' => 'Fast Food','status' => '5','created_at' => '2022-10-17 20:38:53','updated_at' => '2022-10-17 20:38:53'),
        array('id' => '2','name' => 'Extras','status' => '5','created_at' => '2022-10-17 20:58:52','updated_at' => '2022-10-17 20:58:52'),
        array('id' => '3','name' => 'Saucen','status' => '5','created_at' => '2022-10-17 20:59:02','updated_at' => '2022-10-17 20:59:02'),
        array('id' => '4','name' => 'Alkholefrei Getränke','status' => '5','created_at' => '2022-10-17 20:59:17','updated_at' => '2022-10-17 20:59:17'),
        array('id' => '5','name' => 'Beilagen','status' => '5','created_at' => '2022-10-17 20:59:29','updated_at' => '2022-10-17 20:59:29'),
        array('id' => '6','name' => 'Finger Food','status' => '5','created_at' => '2022-10-17 20:59:48','updated_at' => '2023-06-12 22:09:36'),
        array('id' => '7','name' => 'Burger Menüs','status' => '5','created_at' => '2022-10-17 21:02:17','updated_at' => '2023-06-12 22:09:22'),
        array('id' => '8','name' => 'Salate','status' => '5','created_at' => '2022-10-17 21:18:09','updated_at' => '2022-10-17 21:18:09'),
        array('id' => '9','name' => 'Pizza','status' => '5','created_at' => '2022-10-17 21:18:29','updated_at' => '2022-10-17 21:18:29'),
        array('id' => '10','name' => 'Lasagne','status' => '5','created_at' => '2022-10-17 21:19:00','updated_at' => '2022-10-17 21:19:00'),
        array('id' => '11','name' => 'Pasta','status' => '5','created_at' => '2022-10-17 21:19:30','updated_at' => '2022-10-17 21:19:30'),
        array('id' => '12','name' => 'Vegane Produkte','status' => '5','created_at' => '2022-10-17 21:19:42','updated_at' => '2023-06-12 13:56:51')
      );



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
