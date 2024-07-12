<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Enums\Status;

class CategoryTableSeeder extends Seeder
{

    public array $categories = array(
        array('id' => '1','name' => 'Burger Menüs','slug' => 'burger-menus','description' => '<p><span style="color: rgb(60, 76, 79); font-family: JETSansDigital, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 12px; background-color: rgb(252, 252, 252);"><b>Alle Menüs werden mit einer Beilage+ Sauce&nbsp; und einem alkoholfreiem Getränk 0,5l nach Ihrer Wahl serviert.</b></span></p><p><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '1','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:33:46','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '2','name' => 'Vegane Burger','slug' => 'vegane-burger','description' => NULL,'depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '10','requested' => '5','orders' => '6','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:34:37','updated_at' => '2024-03-22 02:44:23'),
        array('id' => '3','name' => 'Pasta','slug' => 'pasta','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Alle Pastagerichte werden mit 100% Hartweizengrieß von Barilla, der bekannten italienischen Pasta-Marke, zubereitet.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '2','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:34:49','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '4','name' => 'Burger','slug' => 'burger','description' => '<span style="color: rgb(60, 76, 79); font-family: JETSansDigital, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 12px; background-color: rgb(252, 252, 252);"><b>Alle Burger werden halal mit hausgemachten Buns, 140g Fleischpatty, Tomaten, roten Zwiebeln, Salat, Gewürzgurken, Mayonnaise, Ketchup und Angels Spezialsauce zubereitet.</b></span><br>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '3','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:34:58','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '5','name' => 'Salate','slug' => 'salate','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Alle Salate werden mit Rucola, Cherrytomaten, Paprika, Gurken, Lollo Rosso, saisonalen Früchten und einem Dressing Ihrer Wahl zubereitet.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '7','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:35:07','updated_at' => '2024-03-28 16:36:44'),
        array('id' => '6','name' => 'Pizza','slug' => 'pizza','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Alle Pizzen werden nach Ihrer Wahl in einem Durchmesser von 32 cm zubereitet.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '6','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:36:03','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '7','name' => 'Lasagne','slug' => 'lasagne','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Alle Lasagnen sind halal, vegetarisch, vegan und werden zu 100% frisch hausgemacht.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '5','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:50:01','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '8','name' => 'Finger Food','slug' => 'finger-food','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Eine Vielfalt an Fingerfood-Snacks, inspiriert von verschiedenen kulinarischen Traditionen aus aller Welt.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '8','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:50:35','updated_at' => '2024-03-28 16:38:39'),
        array('id' => '9','name' => 'Beilagen','slug' => 'beilagen','description' => '<p><span style="color: rgb(36, 46, 48); font-family: JETSansDigital, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(252, 252, 252);">(wir wollen darauf aufmerksam machen, dass die Pommes bei Auslieferung nicht die Qualität haben, wie in unserem Hause)</span></p><p><span style="color: rgb(36, 46, 48); font-family: JETSansDigital, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(252, 252, 252);">Unser Pommes Chips und Sußkartofel werden 100% tagtäglich aus frischen Kartoffeln zubereitet.<br></span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '9','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:50:49','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '10','name' => 'Desserts','slug' => 'desserts','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Desserts: Eine Vielfalt an verlockenden Leckereien, von cremigen bis hin zu frischen Köstlichkeiten.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '10','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:51:14','updated_at' => '2024-03-28 16:43:18'),
        array('id' => '12','name' => 'Getränks','slug' => 'getranks','description' => NULL,'depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '10','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-21 16:52:19','updated_at' => '2024-03-28 16:29:52'),
        array('id' => '13','name' => 'Vegan','slug' => 'vegan','description' => '<p><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space-collapse: preserve;">Alle veganen Produkte werden ausschließlich mit veganen Zutaten zubereitet. Bitte beachten Sie dies in Ihrer Bestellung.</span><br></p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '4','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-09-22 12:06:15','updated_at' => '2024-03-28 16:35:23'),
        array('id' => '15','name' => 'Ramadan Menü','slug' => 'ramadan-menu','description' => '<p>Hier kannst du eigenes Essen zusammenstellen aus unser Zutaten. Sei creative.&nbsp;</p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '10','requested' => '5','orders' => NULL,'creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-10-01 21:01:51','updated_at' => '2024-03-20 16:56:08'),
        array('id' => '16','name' => 'Sauce','slug' => 'sauce','description' => '<p>100% homemade</p>','depth' => '0','left' => '0','right' => '0','parent_id' => '0','status' => '5','requested' => '5','orders' => '10','creator_type' => 'App\\User','creator_id' => '1','editor_type' => 'App\\User','editor_id' => '1','created_at' => '2022-10-03 13:26:41','updated_at' => '2024-03-28 16:35:23')
      );









    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->categories as $key => $category) {
                $categoryObject = Category::create([
                    'name'         => $category['name'],
                    'slug'         => $category['slug'],
                    'description'  => $category['description'],
                    'depth'        => $category['depth'],
                    'left'         => $category['left'],
                    'right'        => $category['right'],
                    'parent_id'    => $category['parent_id'],
                    'status'       => $category['status'],
                    'requested'    => $category['requested'],
                    'creator_type' => $category['creator_type'],
                    'creator_id'   => $category['creator_id'],
                    'editor_type'  => $category['editor_type'],
                    'editor_id'    => $category['editor_id'],
                    'orders' => ++$key
                ]);

                if (file_exists(
                    public_path('/images/seeder/category/category.png')
                )) {
                    $categoryObject->addMedia(
                        public_path('/images/seeder/category/category.png')
                    )->preservingOriginal()->toMediaCollection('categories');
                }
            }
        }
    }
}
