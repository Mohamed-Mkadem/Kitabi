<?php


namespace App\Services;

class NotificationUrlGenerator
{
    public function generateUrl($notificationId, $routeName, $routeParameters = [])
    {
        $url = route($routeName, $routeParameters);
        return $url . '?notification_id=' . $notificationId;
    }
}
