<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return view('admin.notifications', compact('notifications'));
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
        return view('admin.notifications', compact('notifications'));
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
