<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $this->getNotifications($request);
        if ($request->ajax()) {
            $view = view('components.notifications-container', ['notifications' => $notifications])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('client.notifications', compact('notifications'));
    }
    public function filter(Request $request)
    {
        $notifications = $this->getNotifications($request);

        if ($request->ajax()) {
            $view = view('components.notifications-container', ['notifications' => $notifications])->render();

            return response()->json([
                'html' => $view
            ]);
        }
        return view('client.notifications', compact('notifications'));
    }

    private function getNotifications($request)
    {
        $status = $request->status ?? 'all';

        $notificationTypes = [
            'unread' => 'unreadNotifications',
            'read'   => 'readNotifications',
            'all'    => 'notifications',
        ];

        $notificationMethod = $notificationTypes[$status] ?? 'notifications';

        return  Auth::user()->{$notificationMethod}()->paginate();
    }
}
