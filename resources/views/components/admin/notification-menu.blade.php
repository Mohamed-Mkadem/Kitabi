<div class="dropdown-holder">
    <button id="notifications-handler" data-count="{{ $unreadCount }}"
        class="top-bar-btn dropdown-toggle {{ $unreadCount != 0 ? 'has-notifications' : '' }}" aria-pressed="false">
        <i class="fa-regular fa-bell"></i>
    </button>
    <div class="dropdown-menu notifications-dropdown ">
        <h4>الإشعارات</h4>
        @if ($notificationsCount > 0)
            <ul class="notifications-wrapper" id="notifications-wrapper">
                @foreach ($notifications as $notification)
                    <!-- Start Notification -->
                    <li class="notification unread">
                        <img src="{{ asset('storage/' . $notification->data['image']) }}" alt="">
                        <div class="details">
                            <p class="notification-body">
                                <a href="{{ $notification->data['url'] }}"
                                    class="{{ $notification->read_at ? 'read' : 'unread' }}">
                                    {{ $notification->data['body'] }}
                                </a>
                            </p>
                            <p class="notification-time">
                                <i class="fa-regular fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </li>
                    <!-- End Notification -->
                @endforeach
            </ul>
        @else
            <p class="no-notifications">ليس لديك إشعارات</p>
        @endif
        <a href="{{ route('admin.notifications.index') }}" class="see-all d-block t-center">عرض الكلّ</a>
    </div>
</div>
