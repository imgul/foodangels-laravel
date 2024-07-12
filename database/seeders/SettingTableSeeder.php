<?php

namespace Database\Seeders;

use App\Models\Setting;
use Setting as SeederSetting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{

    
    // public array $settings = array(
    //     array('id' => '1','key' => 'site_name','value' => 'Bestellen Sie 100% Halal Burger & Vegan in Köln | Food Angels','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '2','key' => 'site_email','value' => 'info@food-angels.com','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '3','key' => 'site_phone_number','value' => '022116818938','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '4','key' => 'site_logo','value' => '220920_foodangels_logo_website.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '5','key' => 'fav_icon','value' => '230301_foodangels_favicon_logo.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '6','key' => 'site_address','value' => 'Etzelstrasse 222a, 50739 Köln','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '7','key' => 'site_footer','value' => 'Copyright © reserved Foodangels 2023','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '8','key' => 'site_description','value' => 'Entdecken Sie unser hausgemachte Halal-Burger, vegane Speisen in Köln. Genießen Sie unseren Essen bedenkenlos. Testen Sie unser Lieferservice und Pizza-Bringservice.','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '9','key' => 'currency_name','value' => '€','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '10','key' => 'currency_code','value' => '€','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '11','key' => 'locale','value' => 'de','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '12','key' => 'frontend_theme','value' => 'default','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '13','key' => 'twilio_disabled','value' => '1','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '14','key' => 'stripe_key','value' => 'pk_test_Kqmq6XXBwdoYJFLV1CSDnaxz','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '15','key' => 'stripe_secret','value' => 'sk_test_JLeo9KvVZvhgsMzQ7KCl43in','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '16','key' => 'razorpay_key','value' => 'razorpay_key','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '17','key' => 'razorpay_secret','value' => 'razorpay_secret','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '18','key' => 'paystack_key','value' => 'paystack_key','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '19','key' => 'delivery_boy_order_amount_limit','value' => '10000','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '20','key' => 'mail_disabled','value' => '1','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '21','key' => 'google_map_api_key','value' => 'AIzaSyAzVmoS_yZcLG6ThG-ns5rCHWrkYfUMrJA','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '22','key' => 'otp_type_checking','value' => 'email','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '23','key' => 'otp_digit_limit','value' => '6','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '24','key' => 'otp_expire_time','value' => '10','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '25','key' => 'billing-type','value' => '10','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '26','key' => 'support_phone','value' => '0221/16818938','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '27','key' => 'customer_app_name','value' => 'Customer','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '28','key' => 'customer_app_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '29','key' => 'customer_splash_screen_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '30','key' => 'vendor_app_name','value' => 'Vendor','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '31','key' => 'vendor_app_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '32','key' => 'vendor_splash_screen_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '33','key' => 'delivery_app_name','value' => 'Delivery','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '34','key' => 'delivery_app_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '35','key' => 'delivery_splash_screen_logo','value' => '220920_foodangels_icon_app_1024x1024.png','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '36','key' => 'timezone','value' => 'Europe/Berlin','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '37','key' => 'site_short_description','value' => 'Folgen sie uns auf social-media','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '38','key' => 'order_attachment_checking','value' => '5','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '39','key' => 'minimum_order_amount','value' => '10','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '40','key' => 'maximum_order_amount','value' => '35','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '41','key' => 'free_delivery','value' => '1','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '42','key' => 'geolocation_distance_radius','value' => '50','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '43','key' => 'delivery_tax','value' => '1','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '44','key' => 'cookies_details','value' => '3','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '45','key' => 'data_protection','value' => '2','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '46','key' => 'imprint','value' => '2','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '47','key' => 'mail_host','value' => 'frault2.hostarmada.net','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '48','key' => 'mail_port','value' => '465','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '49','key' => 'mail_username','value' => 'info@food-angels.com','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '50','key' => 'mail_password','value' => 'if4QGxp^6C!u','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '51','key' => 'mail_from_name','value' => 'Food-Angels','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '52','key' => 'mail_from_address','value' => 'info@food-angels.com','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '53','key' => 'paypal_client_id','value' => 'Af7N88IZl79eZMjOB3RbRs_tLvtxyxw7-pu5nAsOuw52Hy037eLa7JcECVtUN00sPjlE8ayrTyV7ukE1','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '54','key' => 'paypal_client_secret','value' => 'EEhtATeDiBN8JkRStzzcP3G_e5axH_gVM6VqUmUp4Ex8qrfoEgkNECkXO6aDZdjt4ZgPgiQ0Drc_YdyD','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '55','key' => 'settingtypepayment','value' => 'stripe','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '56','key' => 'fcm_secret_key','value' => 'test firebase key','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '57','key' => 'fcm_topic','value' => 'fcm topic','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '58','key' => 'paypal_app_id','value' => 'bestellung_api1.foodangelscologne.de','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '59','key' => 'paypal_mode','value' => 'live','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '60','key' => 'facebook','value' => 'https://www.facebook.com/foodangelscologne/?locale=de_DE','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '61','key' => 'instagram','value' => 'https://www.instagram.com/foodangels.official/?hl=de','purchase_code' => NULL,'supported_until' => NULL),
    //     array('id' => '62','key' => 'youtube','value' => 'https://www.youtube.com/channel/UCdw5vS5SSJhdUI1AiZjpnpw','purchase_code' => NULL,'supported_until' => NULL)
    //   );


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        
        // if (env('DEMO_MODE')) {
        //     foreach ($this->settings as $item) {
        //         Setting::create([
        //               'key'  => $item['key'], 
        //               'value'  => $item['value'], 
        //         ]);
        //     }
        // }


        $settingArray['site_name'] = 'Bestellen Sie 100% Halal Burger & Vegan in Köln | Food Angels';
        $settingArray['site_email'] = 'info@food-angels.com';
        $settingArray['site_phone_number'] = '022116818938';
        $settingArray['site_logo'] = 'seeder/settings/logo.png';
        $settingArray['fav_icon'] = 'seeder/settings/favicon.png';
        $settingArray['site_address'] = 'Etzelstrasse 222a, 50739 Köln';
        $settingArray['site_footer'] = 'Copyright © reserved Foodangels 2023';
        $settingArray['site_description'] = 'Entdecken Sie unser hausgemachte Halal-Burger, vegane Speisen in Köln. Genießen Sie unseren Essen bedenkenlos. Testen Sie unser Lieferservice und Pizza-Bringservice.';
        $settingArray['currency_name'] = '€';
        $settingArray['currency_code'] = '€';
        $settingArray['locale'] = 'de';
        $settingArray['frontend_theme'] = 'default';
        $settingArray['twilio_disabled'] = '1';
        $settingArray['stripe_key'] = 'pk_test_Kqmq6XXBwdoYJFLV1CSDnaxz';
        $settingArray['stripe_secret'] = 'sk_test_JLeo9KvVZvhgsMzQ7KCl43in';
        $settingArray['razorpay_key'] = 'razorpay_key';
        $settingArray['razorpay_secret'] = 'razorpay_secret';
        $settingArray['paystack_key'] = 'paystack_key';
        $settingArray['delivery_boy_order_amount_limit'] = '10000';
        $settingArray['mail_disabled'] = '1';
        $settingArray['google_map_api_key'] = 'AIzaSyAzVmoS_yZcLG6ThG-ns5rCHWrkYfUMrJA';
        $settingArray['otp_type_checking'] = 'email';
        $settingArray['otp_digit_limit'] = '6';
        $settingArray['otp_expire_time'] = '10';
        $settingArray['billing-type'] = '10';
        $settingArray['support_phone'] = '0221/16818938';
        $settingArray['customer_app_name'] = 'Customer';
        $settingArray['customer_app_logo'] = 'seeder/settings/logo.png';
        $settingArray['customer_splash_screen_logo'] = 'seeder/settings/logo.png';
        $settingArray['vendor_app_name'] = 'Vendor';
        $settingArray['vendor_app_logo'] = 'seeder/settings/logo.png';
        $settingArray['vendor_splash_screen_logo'] = 'seeder/settings/logo.png';
        $settingArray['delivery_app_name'] = 'Delivery';
        $settingArray['delivery_app_logo'] = 'seeder/settings/logo.png';
        $settingArray['delivery_splash_screen_logo'] = 'seeder/settings/logo.png';
        $settingArray['timezone'] = 'Europe/Berlin';
        $settingArray['site_short_description'] = 'Folgen sie uns auf social-media';
        $settingArray['order_attachment_checking'] = '5';
        $settingArray['minimum_order_amount'] = '10';
        $settingArray['maximum_order_amount'] = '35';
        $settingArray['free_delivery'] = '1';
        $settingArray['geolocation_distance_radius'] = '50';
        $settingArray['delivery_tax'] = '1';
        $settingArray['cookies_details'] = '3';
        $settingArray['data_protection'] = '2';
        $settingArray['imprint'] = '2';
        $settingArray['mail_host'] = 'frault2.hostarmada.net';
        $settingArray['mail_port'] = '465';
        $settingArray['mail_username'] = 'info@food-angels.com';
        $settingArray['mail_password'] = 'if4QGxp^6C!u';
        $settingArray['mail_from_name'] = 'Food-Angels';
        $settingArray['mail_from_address'] = 'info@food-angels.com';
        $settingArray['paypal_client_id'] = 'Af7N88IZl79eZMjOB3RbRs_tLvtxyxw7-pu5nAsOuw52Hy037eLa7JcECVtUN00sPjlE8ayrTyV7ukE1';
        $settingArray['paypal_client_secret'] = 'EEhtATeDiBN8JkRStzzcP3G_e5axH_gVM6VqUmUp4Ex8qrfoEgkNECkXO6aDZdjt4ZgPgiQ0Drc_YdyD';
        $settingArray['settingtypepayment'] = 'stripe';
        $settingArray['fcm_secret_key'] = 'test firebase key';
        $settingArray['fcm_topic'] = 'fcm topic';
        $settingArray['paypal_app_id'] = 'bestellung_api1.foodangelscologne.de';
        $settingArray['paypal_mode'] = 'live';
        $settingArray['facebook'] = 'https://www.facebook.com/foodangelscologne/?locale=de_DE';
        $settingArray['instagram'] = 'https://www.instagram.com/foodangels.official/?hl=de';
        $settingArray['youtube'] = 'https://www.youtube.com/channel/UCdw5vS5SSJhdUI1AiZjpnpw';
        $settingArray['banner_title']                    = 'Organic & Tasty Food for your Table.';
        $settingArray['banner_image']                    = 'seeder/settings/hero.png';
        $settingArray['app_mockup']                      = 'seeder/settings/mockup.png';
        


        // $settingArray['site_name']                       = 'Food Bank';
        // $settingArray['site_email']                      = 'info@food-bank.xyz';
        // $settingArray['site_phone_number']               = '+8801777664555';
        // $settingArray['site_logo']                       = 'seeder/settings/logo.png';
        // $settingArray['fav_icon']                        = 'seeder/settings/favicon.png';
        // $settingArray['site_address']                    = 'Dhaka';
        // $settingArray['site_footer']                     = '@ All Rights Reserved';
        // $settingArray['site_description']                = 'Organic & Tasty Food for your Table.';
        // $settingArray['currency_name']                   = 'USD';
        // $settingArray['currency_code']                   = '$';
        // $settingArray['locale']                          = 'en';
        // $settingArray['geolocation_distance_radius']     = 20;
        // $settingArray['order_commission_percentage']     = 5;
        // $settingArray['free_delivery_radius']            = 0;
        // $settingArray['charge_per_kilo']                 = 5;
        // $settingArray['basic_delivery_charge']           = 3;
        // $settingArray['timezone']                        = 'Asia/Dhaka';
        // $settingArray['frontend_theme']                  = 'default';
        // $settingArray['twilio_auth_token']               = '';
        // $settingArray['twilio_account_sid']              = '';
        // $settingArray['twilio_from']                     = '';
        // $settingArray['twilio_disabled']                 = 1;
        // $settingArray['stripe_key']                      = 'pk_test_Kqmq6XXBwdoYJFLV1CSDnaxz';
        // $settingArray['stripe_secret']                   = 'sk_test_JLeo9KvVZvhgsMzQ7KCl43in';
        // $settingArray['razorpay_key']                    = 'rzp_test_eeBR6yhSmKHB65';
        // $settingArray['razorpay_secret']                 = '3wdPy38X8rge55MDf8VDf9k0';
        // $settingArray['paystack_public_key']             = 'pk_test_370ce5565f2a937efae6314df2dccba2781bfa69';
        // $settingArray['paystack_secret_key']             = 'sk_test_e3c7763a083c0fa457da5f105b8bdbe75312235d';
        // $settingArray['paypal_app_id']                   = 'sb-qzxs18789565@business.example.com';
        // $settingArray['paypal_client_id']                = 'AbcV-BG5b30hjofcp2dj41GB1OYXE8_9-egRlV8z4R7vHiA-1mgL3Fvj3pkrOJyq0dC_vHNRAh_tp74p';
        // $settingArray['paypal_client_secret']            = 'EP6r5hEtBc6icJeEseZIiOJqSRnFvqNLI7yxjplzITaObh-t-516gGJ_EysXisLtEavaIMcjrG9aYprz';
        // $settingArray['paypal_mode']                     = 'sandbox';
        // $settingArray['paytm_environment']               = 'sandbox';
        // $settingArray['paytm_merchant_id']               = 'MhjqFc42556626519745';
        // $settingArray['paytm_merchant_key']              = '0dC_Dq!nif6e1Kie';
        // $settingArray['paytm_merchant_website']          = 'WEBSTAGING';
        // $settingArray['paytm_channel']                   = 'WEB';
        // $settingArray['paytm_industry_type']             = 'Retail';
        // $settingArray['phonepe_merchant_id']             = 'PGTESTPAYUAT';
        // $settingArray['phonepe_merchant_user_id']        = 'MUID123';
        // $settingArray['phonepe_env']                     = 'sandbox';
        // $settingArray['phonepe_salt_key']                = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        // $settingArray['phonepe_salt_index']              = '1';
        // $settingArray['sslcommerz_store_name']           = 'testfoodkp1pi';
        // $settingArray['sslcommerz_store_id']             = 'foodk6472ed754a400';
        // $settingArray['sslcommerz_store_password']       = 'foodk6472ed754a400@ssl';
        // $settingArray['sslcommerz_mode']                 = 'sandbox';
        // $settingArray['mail_host']                       = '';
        // $settingArray['mail_port']                       = '';
        // $settingArray['mail_username']                   = '';
        // $settingArray['mail_password']                   = '';
        // $settingArray['order_attachment_checking']       = '5';
        // $settingArray['delivery_boy_order_amount_limit'] = 10000;
        // $settingArray['mail_from_name']                  = 'inilabs';
        // $settingArray['mail_from_address']               = 'demo@food-bank.xyz';
        // $settingArray['mail_disabled']                   = 1;
        // $settingArray['fcm_secret_key']                  = 'AAAAiD42-oQ:APA91bHGPvVS90VfZQalKkMsD-7iYlsoNv8V3BOd2mjHvbxoQi6c1T6uCStbseK3ZBLpOzl3YFxiHn90fgf0w_66U6SA98232tCP2MDm0FR__sj_2Q6aie6ht5l78D5XCj4lT8z4v2JA';
        // $settingArray['firebase_api_key']                = 'AIzaSyDefrY2CxjHICX2m9Z3HiPKWABp4HNheMQ';
        // $settingArray['firebase_authDomain']             = 'foodbank-dc2a5.firebaseapp.com';
        // $settingArray['projectId']                       = 'foodbank-dc2a5';
        // $settingArray['storageBucket']                   = 'foodbank-dc2a5.appspot.com';
        // $settingArray['messagingSenderId']               = '585159342724';
        // $settingArray['appId']                           = '1:585159342724:web:1634134c98a3a6324be0d1';
        // $settingArray['measurementId']                   = 'G-G5MWWTQNBX';
        // $settingArray['facebook_key']                    = '2146804022138583';
        // $settingArray['facebook_secret']                 = 'd0fbfc2866a05acca95f091c547a94f3';
        // $settingArray['facebook_url']                    = 'https://demo.food-bank.xyz/auth/facebook/callback';
        // $settingArray['google_map_api_key']              = 'AIzaSyBvRR2Xoh_6-RY8-6WkU4JE9M9zg1LaL-I';
        // $settingArray['google_key']                      = '86610761817-238dkiq3fnutpugklq5mtthan6gc0qo2.apps.googleusercontent.com';
        // $settingArray['google_secret']                   = 'AIzaSyCELoLWlmIo6Sm2mwTB1lQ3P1_p31B2zkg';
        // $settingArray['google_url']                      = 'https://demo.food-bank.xyz/auth/google/callback';
        // $settingArray['otp_type_checking']               = 'email';
        // $settingArray['otp_digit_limit']                 = 6;
        // $settingArray['otp_expire_time']                 = 10;
        // $settingArray['license_code']                    = session()->has('license_code') ? session()->get('license_code') : "";
        // $settingArray['settingtypesocial']               = 'facebook';
        // $settingArray['facebook']                        = 'https://www.facebook.com/inilabs';
        // $settingArray['instagram']                       = 'https://www.instagram.com/inilabs';
        // $settingArray['youtube']                         = 'https://www.youtube.com/inilabs';
        // $settingArray['twitter']                         = 'https://twitter.com/inilabs';
        // $settingArray['billing-type']                    = 10;
        // $settingArray['support_phone']                   = '+9901555555';
        // $settingArray['customer_app_name']               = 'Customer';
        // $settingArray['customer_app_logo']               = 'seeder/settings/logo.png';
        // $settingArray['customer_splash_screen_logo']     = 'seeder/settings/logo.png';
        // $settingArray['vendor_app_name']                 = 'Vendor';
        // $settingArray['vendor_app_logo']                 = 'seeder/settings/logo.png';
        // $settingArray['vendor_splash_screen_logo']       = 'seeder/settings/logo.png';
        // $settingArray['delivery_app_name']               = 'Delivery';
        // $settingArray['delivery_app_logo']               = 'seeder/settings/logo.png';
        // $settingArray['delivery_splash_screen_logo']     = 'seeder/settings/logo.png';
        // $settingArray['banner_title']                    = 'Organic & Tasty Food for your Table.';
        // $settingArray['banner_image']                    = 'seeder/settings/hero.png';
        // $settingArray['app_mockup']                      = 'seeder/settings/mockup.png';
        // $settingArray['ios_app_link']                    = 'https://play.google.com/store/apps/details?id=com.inilabs.foodbank';
        // $settingArray['android_app_link']                = 'https://play.google.com/store/apps/details?id=com.inilabs.foodbank';

        SeederSetting::set($settingArray);
        SeederSetting::save();
    }
}
