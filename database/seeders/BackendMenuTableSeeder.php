<?php

namespace Database\Seeders;

use App\Models\BackendMenu;
use Illuminate\Database\Seeder;

class BackendMenuTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $parent = [
            'manage_restaurant'=> 3,
            'sales'        => 10,
            'finance'      => 18,
            'administrator'=> 25,
            'report'       => 32,
            'frontend'     => 41,
        ];

        $menus = [
            [
                'name'      => 'dashboard',
                'link'      => 'dashboard',
                'icon'      => 'fas fa-laptop',
                'parent_id' => 0,
                'priority'  => 100,
                'status'    => 1,
            ],
            [
                'name'      => 'restaurants',
                'link'      => 'restaurants',
                'icon'      => 'fa fa-store fa-fw',
                'parent_id' => 0,
                'priority'  => 99,
                'status'    => 1,
            ],
            [
                'name'      => 'manage_restaurants',
                'link'      => '#',
                'icon'      => 'fas fa-utensils',
                'parent_id' => 0,
                'priority'  => 98,
                'status'    => 1,
            ],
            [
                'name'      => 'categories',
                'link'      => 'category',
                'icon'      => 'fas fa-th-large',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 97,
                'status'    => 1,
            ],
            [
                'name'      => 'menu_items_type',
                'link'      => 'menu-items-type',
                'icon'      => 'fas fa-th',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 96,
                'status'    => 1,
            ],
            [
                'name'      => 'menu_items',
                'link'      => 'menu-items',
                'icon'      => 'fas fa-th',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 96,
                'status'    => 1,
            ],
            // [
            //     'name'      => 'cuisines',
            //     'link'      => 'cuisine',
            //     'icon'      => 'fas fa-grip-horizontal',
            //     'parent_id' => $parent['manage_restaurant'],
            //     'priority'  => 95,
            //     'status'    => 0,
            // ],

            // [
            //     'name'      => 'time_slots',
            //     'link'      => 'time-slots',
            //     'icon'      => 'fas fa-calendar-alt',
            //     'parent_id' => $parent['manage_restaurant'],
            //     'priority'  => 94,
            //     'status'    => 0,
            // ],
            [
                'name'      => 'tables',
                'link'      => 'tables',
                'icon'      => 'fas fa-table',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 93,
                'status'    => 1,
            ],
            [
                'name'      => 'rating',
                'link'      => 'rating',
                'icon'      => 'fas fa-star',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 92,
                'status'    => 1,
            ],
            [
                'name'      => 'qr_builder',
                'link'      => 'qr-code',
                'icon'      => 'fas fa-barcode',
                'parent_id' => $parent['manage_restaurant'],
                'priority'  => 91,
                'status'    => 1,
            ],

            [
                'name'      => 'sales',
                'link'      => '#',
                'icon'      => 'fa fa-chart-bar',
                'parent_id' => 0,
                'priority'  => 90,
                'status'    => 1,
            ],
            [
                'name'      => 'reservations',
                'link'      => 'reservation',
                'icon'      => 'fas fa-calendar-check',
                'parent_id' => $parent['sales'],
                'priority'  => 89,
                'status'    => 0,
            ],
            [
                'name'      => 'orders',
                'link'      => 'orders',
                'icon'      => 'fas fa-cart-plus',
                'parent_id' => $parent['sales'],
                'priority'  => 88,
                'status'    => 1,
            ],
            [
                'name'      => 'pending_orders',
                'link'      => 'order_notification',
                'icon'      => 'fas fa-cubes',
                'parent_id' => $parent['sales'],
                'priority'  => 87,
                'status'    => 1,
            ],
            [
                'name'      => 'live_orders',
                'link'      => 'live_orders',
                'icon'      => 'fas fa-cubes',
                'parent_id' => $parent['sales'],
                'priority'  => 87,
                'status'    => 1,
            ],
            [
                'name'      => 'complaints',
                'link'      => 'complaints',
                'icon'      => 'fas fa-flag-checkered',
                'parent_id' => 0,
                'priority'  => 87,
                'status'    => 1,
            ],
            [
                'name'      => 'coupons',
                'link'      => 'coupon',
                'icon'      => 'fas fa-ticket-alt',
                'parent_id' => 0,
                'priority'  => 88,
                'status'    => 1,
            ],
            [
                'name'      => 'promo',
                'link'      => 'promo',
                'icon'      => 'fas fa-ad',
                'parent_id' => 0,
                'priority'  => 87,
                'status'    => 1,
            ],

            [
                'name'      => 'finance',
                'link'      => '#',
                'icon'      => 'fas fa-th-large',
                'parent_id' => 0,
                'priority'  => 86,
                'status'    => 1,
            ],
            [
                'name'      => 'transactions',
                'link'      => 'transaction',
                'icon'      => 'fas fa-wallet',
                'parent_id' => $parent['finance'],
                'priority'  => 85,
                'status'    => 1,
            ],
            [
                'name'      => 'collections',
                'link'      => 'collection',
                'icon'      => 'fas fa-credit-card',
                'parent_id' => $parent['finance'],
                'priority'  => 84,
                'status'    => 1,
            ],
            [
                'name'      => 'request_withdraws',
                'link'      => 'request-withdraw',
                'icon'      => 'fas fa-money-bill-alt',
                'parent_id' => $parent['finance'],
                'priority'  => 83,
                'status'    => 1,
            ],
            [
                'name'      => 'withdraw',
                'link'      => 'withdraw',
                'icon'      => 'fas fa-cash-register',
                'parent_id' => $parent['finance'],
                'priority'  => 82,
                'status'    => 1,
            ],
            [
                'name'      => 'bank_details',
                'link'      => 'bank',
                'icon'      => 'fas fa-university',
                'parent_id' => $parent['finance'],
                'priority'  => 81,
                'status'    => 1,
            ], 
            [
                'name'      => 'tax',
                'link'      => 'tax',
                'icon'      => 'fas fa-hand-holding-usd',
                'parent_id' => $parent['finance'],
                'priority'  => 81,
                'status'    => 1,
            ],

            [
                'name'      => 'administrator',
                'link'      => '#',
                'icon'      => 'fas fa-id-card ',
                'parent_id' => 0,
                'priority'  => 80,
                'status'    => 1,
            ],
            [
                'name'      => 'user',
                'link'      => 'user',
                'icon'      => 'fas fa-users"',
                'parent_id' => $parent['administrator'],
                'priority'  => 79,
                'status'    => 0,
            ],
            [
                'name'      => 'role',
                'link'      => 'role',
                'icon'      => 'fas fa-users-cog',
                'parent_id' => $parent['administrator'],
                'priority'  => 79,
                'status'    => 1,
            ],
            [
                'name'      => 'customers',
                'link'      => 'customers',
                'icon'      => 'fas fa-user',
                'parent_id' => $parent['administrator'],
                'priority'  => 78,
                'status'    => 1,
            ],
            [
                'name'      => 'restaurant_owners',
                'link'      => 'restaurant-owners',
                'icon'      => 'fas fa-user-tie',
                'parent_id' => $parent['administrator'],
                'priority'  => 77,
                'status'    => 0,
            ],
            [
                'name'      => 'delivery_boys',
                'link'      => 'delivery-boys',
                'icon'      => 'fas fa-truck-loading',
                'parent_id' => $parent['administrator'],
                'priority'  => 76,
                'status'    => 1,
            ],
            [
                'name'      => 'update',
                'link'      => 'update',
                'icon'      => 'fas fa-sync-alt',
                'parent_id' => $parent['administrator'],
                'priority'  => 76,
                'status'    => 0,
            ],
            [
                'name'      => 'report',
                'link'      => '#',
                'icon'      => 'fas fa-chart-pie',
                'parent_id' => 0,
                'priority'  => 75,
                'status'    => 1,
            ],
            [
                'name'      => 'restaurant_owner_sales_report',
                'link'      => 'restaurant-owner-sales-report',
                'icon'      => 'fas fa-file-invoice',
                'parent_id' => $parent['report'],
                'priority'  => 74,
                'status'    => 1,
            ],
            [
                'name'      => 'admin_commission',
                'link'      => 'admin-commission-report',
                'icon'      => 'fas fa-file-invoice-dollar',
                'parent_id' => $parent['report'],
                'priority'  => 73,
                'status'    => 0,
            ],
            [
                'name'      => 'credit_balance',
                'link'      => 'credit-balance-report',
                'icon'      => 'fas fa-wallet',
                'parent_id' => $parent['report'],
                'priority'  => 72,
                'status'    => 1,
            ],
            [
                'name'      => 'delivery_order_balance',
                'link'      => 'cash-on-delivery-order-balance-report',
                'icon'      => 'fas fa-chart-bar',
                'parent_id' => $parent['report'],
                'priority'  => 71,
                'status'    => 1,
            ],
            [
                'name'      => 'customer_report',
                'link'      => 'customer-report',
                'icon'      => 'fas fa-chart-line',
                'parent_id' => $parent['report'],
                'priority'  => 70,
                'status'    => 1,
            ],
            [
                'name'      => 'withdraw_report',
                'link'      => 'withdraw-report',
                'icon'      => 'fas fa-money-check',
                'parent_id' => $parent['report'],
                'priority'  => 69,
                'status'    => 1,
            ],
            [
                'name'      => 'collection_report',
                'link'      => 'delivery-boy-collection-report',
                'icon'      => 'fas fa-money-check-alt',
                'parent_id' => $parent['report'],
                'priority'  => 68,
                'status'    => 1,
            ],
            [
                'name'      => 'reservation_report',
                'link'      => 'reservation-report',
                'icon'      => 'fas fa-address-book',
                'parent_id' => $parent['report'],
                'priority'  => 71,
                'status'    => 0,
            ],

            [
                'name'      => 'frontend_cms',
                'link'      => '#',
                'icon'      => 'fas fa-braille',
                'parent_id' => 0,
                'priority'  => 70,
                'status'    => 1,
            ],
            [
                'name'      => 'banners',
                'link'      => 'banner',
                'icon'      => 'fas fa-film',
                'parent_id' => $parent['frontend'],
                'priority'  => 69,
                'status'    => 1,
            ],
            [
                'name'      => 'pages',
                'link'      => 'page',
                'icon'      => 'fas fa-sticky-note',
                'parent_id' => $parent['frontend'],
                'priority'  => 68,
                'status'    => 1,
            ],
            [
                'name'      => 'push_notification',
                'link'      => 'push-notification',
                'icon'      => 'far fa-bell',
                'parent_id' => 0,
                'priority'  => 415,
                'status'    => 1,
            ],
            [
                'name'      => 'language',
                'link'      => 'language',
                'icon'      => 'fas fa-globe',
                'parent_id' => 0,
                'priority'  => 9000,
                'status'    => 1,
            ],
            [
                'name'      => 'settings',
                'link'      => 'setting',
                'icon'      => 'fas fa-cogs',
                'parent_id' => 0,
                'priority'  => 67,
                'status'    => 1,
            ],
            [
                'name'      => 'addons',
                'link'      => 'addons',
                'icon'      => 'fa fa-crosshairs',
                'parent_id' => $parent['administrator'],
                'priority'  => 88,
                'status'    => 0,
            ],
        ];

        BackendMenu::insert($menus);
    }
}
