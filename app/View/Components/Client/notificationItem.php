<?php

namespace App\View\Components\Client;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class notificationItem extends Component
{
    public $unreadCount;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->unreadCount =  Auth::user()->unreadNotifications()->count();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.notification-item');
    }
}
