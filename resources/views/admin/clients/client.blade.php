@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - تفاصيل العميل</title>
@endpush

@push('script')
    @vite('resources/js/clientPage.js')
@endpush

@section('content')
    <div id="client-page">
        <section class="content" id="content">
            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>تفاصيل العميل</h1>

                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.clients.show', $client) }}" currValue="تفاصيل العميل" />
                </div>
                @if ($client->isActive())
                    <button class="modal-controller deleteBtn">
                        حظر
                        <i class="fa-solid fa-ban"></i>
                    </button>
                    <div class="modal-holder">
                        <form action="{{ route('admin.clients.ban', $client) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('PATCH')
                            <i class=" fa-solid fa-ban"></i>
                            <p>
                                هل أنت متأكد من أنّك تريد حظر هذا العميل ؟
                            </p>
                            <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                <button class="cancelBtn">إلغاء</button>
                                <button class="confirmBtn">نعم</button>
                            </div>
                        </form>
                    </div>
                @else
                    <button class="modal-controller greenBtn">
                        فكّ الحظر
                        <i class="fa-solid fa-user-check"></i>
                    </button>
                    <div class="modal-holder">
                        <form action="{{ route('admin.clients.activate', $client) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('PATCH')
                            <i class="fa-solid fa-user-check"></i>
                            <p>
                                هل أنت متأكد من أنّك تريد فكّ الحظر عن هذا العميل ؟
                            </p>
                            <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                <button class="cancelBtn">إلغاء</button>
                                <button class="greenBtn">نعم</button>
                            </div>
                        </form>
                    </div>
                @endif


            </div>
            <!-- End Starter Header -->

            <ul class="tabs-filters-grid grid">
                <li>
                    <h2>المعلومات الشخصيّة</h2>
                    <button data-index="1" aria-checked="true"></button>
                </li>
                <li>
                    <h2>الطلبات</h2>
                    <button data-index="2"></button>
                </li>
                <li>
                    <h2>التقييمات</h2>
                    <button data-index="3"></button>
                </li>
            </ul>


            <div class="tabs-holder">
                <!-- Start Tab -->
                <div class="tab personal-info" data-tab="1" aria-expanded="true">

                    <div class="personal-info-wrapper">
                        <div class="img-holder">
                            <div class="d-flex j-end">
                                <p class="status {{ $client->status }}">
                                    {{ __('auth.' . $client->status) }}
                                </p>
                            </div>
                            <img src="{{ asset('storage/' . $client->photo) }}" alt="">
                            <p class="name">{{ $client->fullName }}</p>
                            <div class="stats-holder">
                                <div class="stat-item">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                    <span>{{ $client->orders_count }}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-star"></i>
                                    <span>{{ $client->reviews_count }}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-dollar"></i>
                                    <span>
                                        {{ $client->formattedSpentAmount }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <h3>المعلومات الشخصيّة</h3>
                            <div class="row">
                                <div class="info-item">
                                    <i class="fa-solid fa-address-book"></i>
                                    <p>{{ $client->fullName }}</p>
                                </div>
                                <div class="info-item">
                                    <i class="fa-solid fa-envelope"></i>
                                    <p dir="ltr">{{ $client->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="info-item">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <p>{{ $client->stateCity }}</p>
                                </div>
                                <div class="info-item">
                                    <i class="fa-solid fa-phone"></i>
                                    <p dir="ltr">{{ $client->phone }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="info-item">
                                    <i class="fa-solid fa-diamond-turn-right"></i>
                                    <p>
                                        {{ $client->address }} </p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="info-item">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <p>
                                        {{ $client->created_at->format('Y - m - d : H:i') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Tab -->
                <!-- Start Tab -->
                <div class="tab orders-tab" data-tab="2" aria-expanded="false">
                    <div class="orders-info">
                        <h3>الطلبات : <span>{{ $client->orders_count }}</span></h3>
                        <div class="stats-grid grid client-page">
                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>قيد الانتظار</h2>
                                    <p>{{ $ordersStatusesCounts['pending'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-hourglass-half pending"></i>
                                </div>
                            </div>
                            <!-- End stat item -->

                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>تمّ تأكيده</h2>
                                    <p>{{ $ordersStatusesCounts['confirmed'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-square-check confirmed"></i>
                                </div>
                            </div>
                            <!-- End stat item -->

                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>تمّ شحنه</h2>
                                    <p>{{ $ordersStatusesCounts['shipped'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-truck-fast shipped"></i>
                                </div>
                            </div>
                            <!-- End stat item -->
                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>تمّ استلامه</h2>
                                    <p>{{ $ordersStatusesCounts['delivered'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-bag-shopping delivered"></i>
                                </div>
                            </div>
                            <!-- End stat item -->
                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>تمّ إرجاعه</h2>
                                    <p>{{ $ordersStatusesCounts['returned'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-rotate-left returned"></i>
                                </div>
                            </div>
                            <!-- End stat item -->
                            <!-- Start stat item -->
                            <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                                <div class="title-value-box">
                                    <h2>تمّ إلغاءه</h2>
                                    <p>{{ $ordersStatusesCounts['cancelled'] }}</p>
                                </div>
                                <div class="icon-holder">
                                    <i class="fa-solid fa-xmark cancelled"></i>
                                </div>
                            </div>
                            <!-- End stat item -->

                        </div>
                    </div>

                    <div class="orders-history mt-2">
                        <h3>طلبات العميل</h3>
                        @if ($client->orders_count > 0)
                            <div class="table-responsive admin-client-orders">
                                <table>

                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>المبلغ (د.ت)</th>
                                            <th>الحالة </th>
                                            <th>التاريخ </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->orders as $order)
                                            <tr>
                                                <td><a href="{{ route('admin.orders.show', $order) }}">#20144</a></td>
                                                <td>{{ $order->formattedAmount }}</td>
                                                <td><span
                                                        class="status {{ $order->status }} ">{{ __('statuses.' . $order->status) }}</span>
                                                </td>
                                                <td dir="ltr">{{ $order->created_at->format('Y - m - d : H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="not-found-wrapper show">
                                <i class="fa-solid fa-cart-arrow-down"></i>
                                <p>لم يقم العميل بأي طلب إلى حد الأن</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End Tab -->
                <!-- Start Tab -->
                <div class="tab reviews-tab" data-tab="3" aria-expanded="false">
                    <div class="reviews-wrapper" id="admin-reviews">
                        <h3>التقييمات : <span>{{ $client->reviews_count }}</span></h3>

                        <div class="grid reviews-grid">

                            @forelse ($client->reviews as $review)
                                <!-- Start Review -->
                                <div class="card  review-card">
                                    <button class="modal-controller"></button>
                                    <div class="modal-holder">
                                        <div class="modal review-details">
                                            <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                                                <h2>تفاصيل التقييم</h2>
                                                <button class="modal-closer">
                                                    <i class="fa-solid fa-close"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>الكتاب</h3>
                                                <div class="info-wrapper book-holder">
                                                    <img src="{{ $review->book->image }}" alt="">
                                                    <div>
                                                        @if ($review->book->deleted_at)
                                                            <p>{{ $review->book->name }} <span>(محذوف)</span></p>
                                                        @else
                                                            <a
                                                                href="{{ route('admin.books.show', $review->book) }}">{{ $review->book->name }}</a>
                                                        @endif
                                                        <p>{{ $review->book->author->name }} </p>
                                                        <p>{{ $review->book->publisher->name }} </p>

                                                        <div class="rate-holder">
                                                            <span class="rate">{{ $review->book->rate }}</span>
                                                            <i class="fa-solid fa-star"></i>
                                                            <span
                                                                class="reviews-count">({{ $review->book->formattedReviewsCount }})</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <h3>التقييم</h3>
                                                <div class="d-flex a-center f-wrap stars-holder">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fa-solid fa-star {{ $i <= $review->stars ? 'filled' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <p class="comment ">
                                                    {{ $review->comment }}
                                                </p>
                                                <div class="d-flex j-end mt-1">

                                                    <form action="{{ route('admin.reviews.destroy', $review) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="deleteBtn">حذف التقييم</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header d-flex j-between f-wrap gap-1 a-center">
                                        <p class="date">
                                            <i class="fa-regular fa-clock"></i>
                                            <span dir="ltr">
                                                {{ $review->created_at->format('Y - m - d : H:i') }}</span>
                                        </p>
                                        <div class="d-flex a-center j-between f-wrap stars-holder">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa-solid fa-star {{ $i <= $review->stars ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="book-holder ">
                                            <img src="{{ $review->book->image }}" alt="">
                                            <h2>{{ $review->book->name }}</h2>
                                        </div>
                                        <p>
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                </div>
                                <!-- End Review -->
                            @empty
                                <p>لم يقم هذا العميل بأي تقييم بعد</p>
                            @endforelse

                        </div>

                    </div>
                </div>
                <!-- End Tab -->
            </div>


        </section>
    </div>
@endsection
