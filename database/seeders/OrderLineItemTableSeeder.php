<?php
namespace Database\Seeders;

use App\Models\OrderLineItem;
use Illuminate\Database\Seeder;

class OrderLineItemTableSeeder extends Seeder
{

    public array $orderLineItems = array(
        array('id' => '1','order_id' => '1','restaurant_id' => '1','menu_item_id' => '8','quantity' => '2','unit_price' => '14.10','discounted_price' => '0.00','item_total' => '28.20','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-03 20:01:28','updated_at' => '2023-07-03 20:01:28'),
        array('id' => '2','order_id' => '2','restaurant_id' => '1','menu_item_id' => '4','quantity' => '2','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '27.00','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-04 17:59:54','updated_at' => '2023-07-04 17:59:54'),
        array('id' => '3','order_id' => '3','restaurant_id' => '1','menu_item_id' => '54','quantity' => '1','unit_price' => '10.90','discounted_price' => '0.00','item_total' => '10.90','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-06 13:49:03','updated_at' => '2023-07-06 13:49:03'),
        array('id' => '4','order_id' => '4','restaurant_id' => '1','menu_item_id' => '4','quantity' => '3','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '40.50','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-06 21:03:19','updated_at' => '2023-07-06 21:03:19'),
        array('id' => '5','order_id' => '5','restaurant_id' => '1','menu_item_id' => '4','quantity' => '1','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '13.50','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-06 21:04:29','updated_at' => '2023-07-06 21:04:29'),
        array('id' => '6','order_id' => '6','restaurant_id' => '1','menu_item_id' => '4','quantity' => '2','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '27.00','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-07 09:32:52','updated_at' => '2023-07-07 09:32:52'),
        array('id' => '7','order_id' => '7','restaurant_id' => '1','menu_item_id' => '4','quantity' => '2','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '27.00','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-07 10:04:55','updated_at' => '2023-07-07 10:04:55'),
        array('id' => '8','order_id' => '8','restaurant_id' => '1','menu_item_id' => '4','quantity' => '1','unit_price' => '13.50','discounted_price' => '0.00','item_total' => '13.50','menu_item_variations' => '[]','menu_item_options' => '[]','variation_total' => '0.00','option_total' => '0.00','instructions' => '','created_at' => '2023-07-07 15:32:31','updated_at' => '2023-07-07 15:32:31')
       );





    public function run()
    {
        if (env('DEMO_MODE')) {
            foreach ($this->orderLineItems as $orderLineItem) {
                OrderLineItem::insert([
                    'order_id'               => $orderLineItem['order_id'],
                    'restaurant_id'          => $orderLineItem['restaurant_id'],
                    'menu_item_id'           => $orderLineItem['menu_item_id'],
                    'quantity'               => $orderLineItem['quantity'],
                    'unit_price'             => $orderLineItem['unit_price'],
                    'discounted_price'       => $orderLineItem['discounted_price'],
                    'item_total'             => $orderLineItem['item_total'],
                    // 'menu_item_variation_id' => $orderLineItem['menu_item_variations'],
                    // 'options'                => $orderLineItem['options'],
                    // 'options_total'          => $orderLineItem['options_total'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
