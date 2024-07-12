<?php

namespace App\Helpers;

use App\Models\PushNotification;

class Support
{
    public static function checking()
    {
        $postData = array(
            'purchase_code' => setting('web_purchase_code'),
            'username'      => setting('web_purchase_username'),
            'itemId'        => config('installer.itemId'),
            'ip'            => Ip::get(),
            'domain'        => getDomain(),
            'purpose'       => 'install',
            "sql"           => false,
            'product_name'  => config('installer.item_name'),
            'version'       => config('installer.item_version')
        );


        try {
            $apiUrl = config('installer.purchaseCodeCheckerUrl');
            $data = Curl::request($apiUrl, $postData);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return $data;
    }

    public static function notificationCount()
    {
        // $count = PushNotification::query()->where('customer_id', auth()->id())->orWhere('customer_id', null)->count();

        $userId = auth()->id();
        $count = PushNotification::query()
            ->leftJoin('push_notification_reads', function ($join) use ($userId) {
                $join->on('push_notifications.id', '=', 'push_notification_reads.push_notification_id')
                    ->where('push_notification_reads.customer_id', '=', $userId);
            })
            ->where(function ($query) {
                $query->whereNull('push_notification_reads.customer_id');
            })
            ->count();
        return $count;
    }
}
