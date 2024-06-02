<a href="{{ route('client.notifications.index') }}"
    class="user-action-item notifications-item icon-btn {{ $unreadCount ? 'has-notifications' : '' }}"
    id="notifications-handler" data-count="{{ $unreadCount }}">
    <i class="fa-regular fa-bell"></i>
</a>
