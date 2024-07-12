<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BestSellingCategory;

class BestSellingCategorySeeder extends Seeder
{


    public array $bestSellingCategories = array(
        array('id' => '1','category_id' => '1','restaurant_id' => '1','counter' => '16','created_at' => '2022-10-25 10:28:31','updated_at' => '2023-12-12 02:26:41'),
        array('id' => '2','category_id' => '16','restaurant_id' => '1','counter' => '1','created_at' => '2022-11-02 21:34:50','updated_at' => '2022-11-02 21:34:50'),
        array('id' => '3','category_id' => '4','restaurant_id' => '1','counter' => '8','created_at' => '2022-11-02 21:34:50','updated_at' => '2024-04-30 21:56:28'),
        array('id' => '4','category_id' => '2','restaurant_id' => '1','counter' => '2','created_at' => '2023-07-15 00:36:39','updated_at' => '2023-07-23 00:04:39'),
        array('id' => '5','category_id' => '13','restaurant_id' => '1','counter' => '16','created_at' => '2023-07-15 00:36:39','updated_at' => '2024-04-30 21:56:28'),
        array('id' => '6','category_id' => '6','restaurant_id' => '1','counter' => '9','created_at' => '2023-08-13 00:33:14','updated_at' => '2023-12-05 00:27:58'),
        array('id' => '7','category_id' => '8','restaurant_id' => '1','counter' => '3','created_at' => '2023-08-13 00:33:14','updated_at' => '2023-10-17 15:02:48'),
        array('id' => '8','category_id' => '9','restaurant_id' => '1','counter' => '3','created_at' => '2023-08-13 00:33:14','updated_at' => '2024-04-30 21:56:28'),
        array('id' => '9','category_id' => '5','restaurant_id' => '1','counter' => '2','created_at' => '2023-08-13 00:33:14','updated_at' => '2023-10-23 00:37:26'),
        array('id' => '10','category_id' => '10','restaurant_id' => '1','counter' => '1','created_at' => '2023-12-12 02:26:41','updated_at' => '2023-12-12 02:26:41')
      );






    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->bestSellingCategories as $bestSellingCategory) {
                BestSellingCategory::create([
                    'category_id'   => $bestSellingCategory['category_id'],
                    'restaurant_id' => $bestSellingCategory['restaurant_id'],
                    'counter'       => $bestSellingCategory['counter'],
                ]);
            }
        }
    }
}
