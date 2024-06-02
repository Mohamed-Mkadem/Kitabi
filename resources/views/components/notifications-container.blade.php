@if ($notifications->count() > 0)
    <ul class="notifications-wrapper">
        @foreach ($notifications as $notification)
            <!-- Start Notification -->
            <li class="notification {{ $notification->read_at ? 'read' : 'unread' }}">
                <img src="{{ asset('storage/' . $notification->data['image']) }}" alt="">
                <div class="details">
                    <p class="notification-body">
                        {{ $notification->data['body'] }}
                    </p>
                    <p class="notification-time">
                        <i class="fa-regular fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                    </p>
                    <a href="{{ $notification->data['url'] }}"></a>
                </div>
            </li>
            <!-- End Notification -->
        @endforeach


    </ul>
    <!-- Start Pagination -->
    {!! $notifications->appends(request()->input())->links() !!}
    <!-- End Pagination -->
@else
    <div class="not-found-wrapper show">
        <i class="fa-solid fa-circle-info"></i>
        <p>لم يتمّ العثور على أيّ نتائج</p>
    </div>
@endif
