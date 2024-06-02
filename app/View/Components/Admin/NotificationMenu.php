<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{

    public $notifications;
    public $unreadCount;
    public $notificationsCount;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $admin = Auth::user();

        $this->unreadCount = $admin->unreadNotifications()->count();
        $this->notifications = $admin->notifications()->take(4)->get();
        $this->notificationsCount = $admin->notifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.notification-menu');
    }
}
