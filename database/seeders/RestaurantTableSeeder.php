<?php

namespace Database\Seeders;

use App\Enums\TableStatus;
use App\Models\Restaurant;
use App\Enums\PickupStatus;
use App\Enums\WaiterStatus;
use App\Enums\CurrentStatus;
use App\Enums\DeliveryStatus;

use App\Enums\RestaurantStatus;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder{
    public array $restaurants = [

        [
            'user_id'         => "7",
            'name'            => "Food Angels",
            'slug'            => "food-angels",
            'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
            'lat'             => "23.788172232292922",
            'long'            =>"90.35950183868408",
            'opening_time'    => "09:00:00",
            'closing_time'    => "23:00:00",
            'address'         => "250 W 72nd St, New York, United State",
            'status'          => RestaurantStatus::ACTIVE,
            'current_status'  => CurrentStatus::YES,
            'delivery_status' => DeliveryStatus::ENABLE,
            'pickup_status'   => PickupStatus::ENABLE,
            'table_status'    => TableStatus::ENABLE,
            'applied'         => false,
            'creator_type'    => 'App\Models\User',
            'creator_id'      => 1,
            'editor_type'     => 'App\Models\User',
            'editor_id'       => 1,
            'waiter_status'   => WaiterStatus::ACTIVE,
        ],
        [
            'id' => 2,
            'user_id'         => "7",

            'name' => 'Vegi Devils',
            'slug' => 'vegi-devils',
            'description' => 'Halal Vegan',
            'lat' => '51.02113',
            'long' => '6.7552295',
            'opening_time' => '08:15:00',
            'closing_time' => '23:15:00',
            'address' => 'Venloer str 100',
            'status' => 10,
            'current_status' => 10,
            'delivery_status' => 10,
            'pickup_status' => 10,
            'table_status' => 0,
            'applied' => 0,
            'creator_type' => 'App\\User',
            'creator_id' => 1,
            'editor_type' => 'App\\User',
            'editor_id' => 1,
            'created_at' => '2022-11-02 17:10:56',
            'updated_at' => '2023-04-09 12:56:16',
            'waiter_status' => 0,
            'week_days_opening' => '08:00:00',
            'week_days_closing' => '23:00:00',
            'weekend_opening' => '14:00:00',
            'weekend_closing' => '22:00:00',
        ],        


        // [
        //     'user_id'         => "7",
        //     'name'            => "Sultan’s Dine",
        //     'slug'            => "sultans-dine",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.788172232292922",
        //     'long'            =>"90.35950183868408",
        //     'opening_time'    => "09:00:00",
        //     'closing_time'    => "23:00:00",
        //     'address'         => "250 W 72nd St, New York, United State",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "8",
        //     'name'            => "Mr Beast Burger",
        //     'slug'            => "mr-beast-burger",
        //     'description'     => "AA regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.788132962903646",
        //     'long'            =>"90.37362098693848",
        //     'opening_time'    => "01:00:00",
        //     'closing_time'    => "24:00:00",
        //     'address'         => "West Shewrapara Dhaka Bangladesh",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "9",
        //     'name'            => "Starbucks",
        //     'slug'            => "starbucks",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.784441587340527",
        //     'long'            =>"90.36482334136963",
        //     'opening_time'    => "01:00:00",
        //     'closing_time'    => "23:00:00",
        //     'address'         => "170 W 22nd South Paikpara.",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "10",
        //     'name'            => "McDonalds",
        //     'slug'            => "mcdonalds",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.77898287180741",
        //     'long'            => "90.37160396575928",
        //     'opening_time'    => "01:00:00",
        //     'closing_time'    => "23:00:00",
        //     'address'         => "National Museum of Science and Technology, New York",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "11",
        //     'name'            => "Burger King",
        //     'slug'            => "burger-king",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.77572324174743",
        //     'long'            =>"90.36967277526855",
        //     'opening_time'    => "01:00:00",
        //     'closing_time'    => "21:00:00",
        //     'address'         => "F11/A & F11/B, Liberation War Museum , Dhaka 1207",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "12",
        //     'name'            => "Gustosa Pasta",
        //     'slug'            => "gustosa-pasta",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.79516199456447",
        //     'long'            => "90.29062271118164",
        //     'opening_time'    => "23:00:00",
        //     'closing_time'    => "01:00:00",
        //     'address'         => "Q7WR+377 Boliarpur Bus Station, Delhi",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "13",
        //     'name'            => "Wham! Bam! Burrito",
        //     'slug'            => "wham-bam-burrito",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.777843974205368",
        //     'long'            => "90.36091804504395",
        //     'opening_time'    => "02:45:00",
        //     'closing_time'    => "23:00:00",
        //     'address'         => "250 W 72nd St, New York, United State",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ],

        // [
        //     'user_id'         => "14",
        //     'name'            => "The Salad God",
        //     'slug'            => "the-salad-god",
        //     'description'     => "A regal culinary retreat where opulence meets flavor, offering a menu that fuses tradition and innovation. Indulge in a majestic dining experience, where every dish is crafted with a commitment to royal excellence and hospitality.",
        //     'lat'             => "23.785305535697763",
        //     'long'            =>"90.35289287567139",
        //     'opening_time'    => "23:00:00",
        //     'closing_time'    => "01:00:00",
        //     'address'         => "250 W 72nd St, New York, United State",
        //     'status'          => RestaurantStatus::ACTIVE,
        //     'current_status'  => CurrentStatus::YES,
        //     'delivery_status' => DeliveryStatus::ENABLE,
        //     'pickup_status'   => PickupStatus::ENABLE,
        //     'table_status'    => TableStatus::ENABLE,
        //     'applied'         => false,
        //     'creator_type'    => 'App\Models\User',
        //     'creator_id'      => 1,
        //     'editor_type'     => 'App\Models\User',
        //     'editor_id'       => 1,
        //     'waiter_status'   => WaiterStatus::ACTIVE,
        // ]
    ];

    // public array $restaurants = array(
    //     array('id' => '1','name' => 'FOODANGELS','slug' => 'foodangels','description' => 'Adresse eingeben und loslegen.','lat' => '50.9779016','long' => '6.9300706','opening_time' => '12:00:00','closing_time' => '22:00:00','address' => 'Etzelstraße 231, 50739 Köln, Germany','status' => '5','current_status' => '5','delivery_status' => '5','pickup_status' => '5','table_status' => '0','applied' => '0','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-10-17 20:38:04','updated_at' => '2024-05-07 15:32:11','waiter_status' => '0','week_days_opening' => '12:00:00','week_days_closing' => '22:00:00','weekend_opening' => '14:00:00','weekend_closing' => '22:00:00'),
    //     array('id' => '2','name' => 'Vegi Devils','slug' => 'vegi-devils','description' => 'Halal Vegan','lat' => '51.02113','long' => '6.7552295','opening_time' => '08:15:00','closing_time' => '23:15:00','address' => 'Venloer str 100','status' => '10','current_status' => '10','delivery_status' => '10','pickup_status' => '10','table_status' => '0','applied' => '0','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-11-02 17:10:56','updated_at' => '2023-04-09 12:56:16','waiter_status' => '0','week_days_opening' => '08:00:00','week_days_closing' => '23:00:00','weekend_opening' => '14:00:00','weekend_closing' => '22:00:00')
    //   );

    /**
     * Run the database seeds.
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->restaurants as $restaurant) {
                $restaurantObject = Restaurant::create([
                    'user_id'         => $restaurant['user_id'],
                    'name'            => $restaurant['name'],
                    'slug'            => $restaurant['slug'],
                    'description'     => $restaurant['description'],
                    'lat'             => $restaurant['lat'],
                    'long'            => $restaurant['long'],
                    'opening_time'    => $restaurant['opening_time'],
                    'closing_time'    => $restaurant['closing_time'],
                    'address'         => $restaurant['address'],
                    'status'          => $restaurant['status'],
                    'current_status'  => $restaurant['current_status'],
                    'delivery_status' => $restaurant['delivery_status'],
                    'pickup_status'   => $restaurant['pickup_status'],
                    'table_status'    => $restaurant['table_status'],
                    'applied'         => $restaurant['applied'],
                    'creator_type'    => $restaurant['creator_type'],
                    'creator_id'      => $restaurant['creator_id'],
                    'editor_type'     => $restaurant['editor_type'],
                    'editor_id'       => $restaurant['editor_id'],
                    'waiter_status'   => $restaurant['waiter_status'],
                ]);
                if (file_exists(
                    public_path('/images/seeder/restaurant/' . $restaurant['slug'].'.jpg')
                )) {
                    $restaurantObject->addMedia(
                        public_path('/images/seeder/restaurant/' .  $restaurant['slug'].'.jpg')
                    )->preservingOriginal()->toMediaCollection('restaurant');
                }
            }
        }
    }
}
