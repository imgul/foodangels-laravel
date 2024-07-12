<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantPostalCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestaurantPostalCodeTableSeeder extends Seeder
{



    public array   $branch_postal_codes = array(
        array('id' => '1','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50739','delivery_time' => '45','min_order' => '15','max_order' => '45','created_at' => '2022-09-21 16:23:24','updated_at' => '2023-06-06 15:18:23'),
        array('id' => '2','restaurant_id' => '1','delivery_charge' => '2.00','postal_code' => '50670','delivery_time' => '55','min_order' => '20','max_order' => '30','created_at' => '2022-09-21 14:05:11','updated_at' => '2022-09-21 14:08:40'),
        array('id' => '3','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50733','delivery_time' => '55','min_order' => '10','max_order' => '30','created_at' => '2022-09-21 14:06:48','updated_at' => '2022-09-21 14:06:48'),
        array('id' => '4','restaurant_id' => '1','delivery_charge' => '2.00','postal_code' => '50735','delivery_time' => '55','min_order' => '10','max_order' => '30','created_at' => '2022-09-21 14:07:36','updated_at' => '2022-09-21 14:07:36'),
        array('id' => '5','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50737','delivery_time' => '55','min_order' => '10','max_order' => '30','created_at' => '2022-09-21 14:08:05','updated_at' => '2022-09-21 14:08:05'),
        array('id' => '6','restaurant_id' => '1','delivery_charge' => '2.00','postal_code' => '50765','delivery_time' => '59','min_order' => '20','max_order' => '35','created_at' => '2022-09-21 14:09:39','updated_at' => '2022-09-21 14:09:39'),
        array('id' => '7','restaurant_id' => '1','delivery_charge' => '2.00','postal_code' => '50767','delivery_time' => '59','min_order' => '20','max_order' => '35','created_at' => '2022-09-21 14:10:04','updated_at' => '2022-09-21 14:10:04'),
        array('id' => '8','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50823','delivery_time' => '55','min_order' => '12','max_order' => '30','created_at' => '2022-09-21 14:10:41','updated_at' => '2022-09-21 14:10:41'),
        array('id' => '9','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50825','delivery_time' => '55','min_order' => '12','max_order' => '35','created_at' => '2022-09-21 14:11:03','updated_at' => '2022-09-21 14:11:03'),
        array('id' => '10','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50827','delivery_time' => '55','min_order' => '12','max_order' => '25','created_at' => '2022-09-21 14:11:31','updated_at' => '2022-09-21 14:11:31'),
        array('id' => '11','restaurant_id' => '1','delivery_charge' => '2.00','postal_code' => '50829','delivery_time' => '55','min_order' => '20','max_order' => '35','created_at' => '2022-09-21 14:11:57','updated_at' => '2022-09-21 14:11:57'),
        array('id' => '12','restaurant_id' => '1','delivery_charge' => '3.00','postal_code' => '50674','delivery_time' => '65','min_order' => '25','max_order' => '35','created_at' => '2022-09-21 14:12:23','updated_at' => '2022-09-21 14:12:23'),
        array('id' => '13','restaurant_id' => '1','delivery_charge' => '3.00','postal_code' => '50672','delivery_time' => '59','min_order' => '20','max_order' => '40','created_at' => '2022-09-21 14:14:04','updated_at' => '2022-09-21 14:14:26'),
        array('id' => '14','restaurant_id' => '1','delivery_charge' => '3.00','postal_code' => '50660','delivery_time' => '59','min_order' => '25','max_order' => '45','created_at' => '2022-09-21 14:15:08','updated_at' => '2022-09-21 14:15:08'),
        array('id' => '15','restaurant_id' => '1','delivery_charge' => '3.00','postal_code' => '50931','delivery_time' => '60','min_order' => '25','max_order' => '45','created_at' => '2022-09-21 14:15:34','updated_at' => '2022-09-21 14:15:34'),
        array('id' => '16','restaurant_id' => '1','delivery_charge' => '3.00','postal_code' => '50769','delivery_time' => '60','min_order' => '25','max_order' => '45','created_at' => '2022-09-21 14:16:02','updated_at' => '2023-11-25 22:34:33'),
        array('id' => '17','restaurant_id' => '2','delivery_charge' => '2.00','postal_code' => '50765','delivery_time' => '50','min_order' => '30','max_order' => '50','created_at' => '2022-12-28 23:17:09','updated_at' => '2022-12-28 23:17:09'),
        array('id' => '18','restaurant_id' => '2','delivery_charge' => '2.00','postal_code' => '50738','delivery_time' => '40','min_order' => '20','max_order' => '50','created_at' => '2023-02-19 18:44:32','updated_at' => '2023-02-19 18:44:32'),
        array('id' => '19','restaurant_id' => '2','delivery_charge' => '2.00','postal_code' => '50668','delivery_time' => '60','min_order' => '30','max_order' => '50','created_at' => '2023-02-19 18:47:04','updated_at' => '2023-02-19 18:47:04'),
        array('id' => '20','restaurant_id' => '2','delivery_charge' => '3.00','postal_code' => '50674','delivery_time' => '45','min_order' => '23','max_order' => '34','created_at' => '2023-02-19 18:47:29','updated_at' => '2023-02-19 18:47:29'),
        array('id' => '21','restaurant_id' => '2','delivery_charge' => '3.00','postal_code' => '50858','delivery_time' => '56','min_order' => '5','max_order' => '56','created_at' => '2023-02-19 18:47:48','updated_at' => '2023-02-19 18:47:48'),
        array('id' => '22','restaurant_id' => '3','delivery_charge' => '5.00','postal_code' => '6000','delivery_time' => '5','min_order' => '15','max_order' => '0','created_at' => '2023-06-07 05:02:47','updated_at' => '2023-06-07 05:02:47'),
        array('id' => '24','restaurant_id' => '1','delivery_charge' => '1.00','postal_code' => '50','delivery_time' => '50','min_order' => '15','max_order' => '1','created_at' => '2024-02-25 21:41:13','updated_at' => '2024-02-26 18:21:28')
      );






    /**
     * Run the database seeds.
     */




    public function run(): void
    {
        if (env('DEMO_MODE')) {
            foreach ($this->branch_postal_codes as $postal_codes) {
                RestaurantPostalCode::create([
                    'restaurant_id'   => $postal_codes['restaurant_id'],
                    'delivery_charge' => $postal_codes['delivery_charge'],
                    'postal_code'       => $postal_codes['postal_code'],
                    'delivery_time'       => $postal_codes['delivery_time'],
                    'min_order'       => $postal_codes['min_order'],
                    'max_order'       => $postal_codes['max_order'],
                    'created_at'       => $postal_codes['created_at'],
                    'updated_at'       => $postal_codes['updated_at'],
                ]);
            }
        }
    }
}
