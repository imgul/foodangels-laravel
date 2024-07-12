<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryStatusHistories;
class DeliveryStatusHistoriesSeeder extends Seeder
{
    // public array $deliveryStatusOptions = [
    //     [
    //         "order_id" => 4,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 7,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 8,
    //         "user_id" => 3,
    //         "status" => 10,
    //     ],
    //     [
    //         "order_id" => 8,
    //         "user_id" => 6,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 13,
    //         "user_id" => 6,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 14,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 23,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 3,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 18,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 28,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 29,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 19,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 22,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 20,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 21,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 43,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 42,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 37,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    //     [
    //         "order_id" => 46,
    //         "user_id" => 3,
    //         "status" => 5,
    //     ],
    // ];


    public array $deliveryStatusOptions = array(
        array('id' => '1','order_id' => '30','user_id' => '227','status' => '5','created_at' => '2023-08-07 10:45:04','updated_at' => '2023-08-07 10:45:04'),
        array('id' => '2','order_id' => '1268','user_id' => '1','status' => '5','created_at' => '2024-03-10 01:29:55','updated_at' => '2024-03-10 01:29:55'),
        array('id' => '3','order_id' => '1224','user_id' => '1','status' => '5','created_at' => '2024-03-13 00:29:57','updated_at' => '2024-03-13 00:29:57'),
        array('id' => '4','order_id' => '1137','user_id' => '1','status' => '5','created_at' => '2024-03-13 00:31:59','updated_at' => '2024-03-13 00:31:59'),
        array('id' => '5','order_id' => '1067','user_id' => '1','status' => '5','created_at' => '2024-03-13 02:08:29','updated_at' => '2024-03-13 02:08:29'),
        array('id' => '6','order_id' => '1318','user_id' => '1','status' => '5','created_at' => '2024-04-04 14:26:21','updated_at' => '2024-04-04 14:26:21'),
        array('id' => '7','order_id' => '1317','user_id' => '1','status' => '5','created_at' => '2024-04-04 14:26:23','updated_at' => '2024-04-04 14:26:23'),
        array('id' => '8','order_id' => '1376','user_id' => '1','status' => '5','created_at' => '2024-04-06 17:40:03','updated_at' => '2024-04-06 17:40:03'),
        array('id' => '9','order_id' => '1375','user_id' => '1','status' => '5','created_at' => '2024-04-06 17:50:50','updated_at' => '2024-04-06 17:50:50'),
        array('id' => '10','order_id' => '1401','user_id' => '1','status' => '5','created_at' => '2024-04-11 01:04:53','updated_at' => '2024-04-11 01:04:53')
      );

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->deliveryStatusOptions as $deliveryStatusOption) {
                DeliveryStatusHistories::create([
                    'order_id' => $deliveryStatusOption['order_id'],
                    'user_id'  => $deliveryStatusOption['user_id'],
                    'status'   => $deliveryStatusOption['status'],
                ]);
            }
        }
    }
}
