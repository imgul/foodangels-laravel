<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = PushNotification::query()->with(['reads'])->where('customer_id', auth()->id())->orWhere('customer_id', null)->orderBy('id', 'desc')->get();

        return view('frontend.notifications', compact('notifications'));
    }

    public function readNotification(Request $request)
    {

        try {

            $user = User::find($request->customer_id);
            $notification = PushNotification::find($request->push_notification_id);

            // $user->notification_read()->attach($notification->id);

            if ($user->notification_read->contains($notification->id)) {
               
                return response()->json(['status' => 'already_read']);
            } else {
               
                $user->notification_read()->syncWithoutDetaching([$notification->id]);
                return response()->json(['status' => 'success']);
            }

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
