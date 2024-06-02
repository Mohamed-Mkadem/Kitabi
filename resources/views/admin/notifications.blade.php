@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الإشعارات</title>
@endpush

@push('script')
    @vite('resources/js/notifications.js')
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>الإشعارات</h1>

                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.notifications.index') }}" currValue="الإشعارات" />
            </div>



        </div>
        <!-- End Starter Header -->

        <div class="notifications-holder">
            <div class="header">
                <h2 class="t-center"> أخر الإشعارات </h2>
                <div class="statuses-holder">
                    <div class="status form-element">
                        <label for="all">الكلّ</label>
                        <input data-type="admin" type="radio" id="all" name="status" value="all"
                            @if (request()->status == 'all' || request()->status == null) @checked(true) @endif>
                    </div>
                    <div class="status form-element">
                        <label for="read">المقروءة</label>
                        <input data-type="admin" type="radio" id="read"
                            {{ request()->status == 'read' ? 'checked' : '' }} name="status" value="read">
                    </div>
                    <div class="status form-element">
                        <label for="unread">غير المقروءة</label>
                        <input data-type="admin" type="radio" id="unread"
                            {{ request()->status == 'unread' ? 'checked' : '' }} name="status" value="unread">
                    </div>

                </div>
            </div>
            <div class="body" id="notifications-container">
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
                                    <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}"></a>
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
            </div>
        </div>

    </section>
@endsection
