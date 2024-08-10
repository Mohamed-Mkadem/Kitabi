@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الرئيسية</title>
@endpush
@push('script')
    @vite('resources/js/shippingCost.js')
@endpush

@section('content')
    <section class="content" id="content">
        @include('components.errors')

        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>مرحبا كتابي</h1>
                <p class="today-stats">هذه بعض الإحصائيات السريعة</p>
            </div>
            <button class="starter-header-btn add-btn modal-controller" id="add-btn">
                تعديل تكلفة الشحن
                <i class="fa-solid fa-plus"></i>
            </button>
            <div class="modal-holder ">
                <div class="modal new-auth-cat-pub-modal">
                    <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                        <h2>تعديل تكلفة الشحن</h2>
                        <button class="modal-closer">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.updateShippingCost') }}" method="post" id="shippingCostForm">
                        @csrf
                        @method('PATCH')
                        <div class="form-control mb-1">
                            <label for="shipping_cost-input" class="required"> تكلفة الشحن (د.ت)</label>
                            <input type="number" name="shipping_cost" id="shipping_cost-input" placeholder="اسم التصنيف">
                            <p class="error-message ">هذا الحقل إجباري</p>
                        </div>

                        <button type="submit" class="submitBtn mt-1">تعديل</button>
                    </form>
                </div>
            </div>




        </div>
        <!-- End Starter Header -->

        <!-- Start Quick Stats -->
        <div class="quick-stats-holder" id="quick-stats-holder">
            <!-- Start Stat -->
            <div class="stat">
                <div class="d-flex j-between f-wrap a-center">
                    <p class="title">
                        الطلبات
                    </p>
                    <i class="fa-solid fa-cart-arrow-down primary"></i>
                </div>
                <div class="d-flex j-between f-wrap a-end">
                    <p class="value">
                        {{ $counts['orders'] }}
                    </p>
                    <a href="{{ route('admin.orders.index') }}">كلّ الطلبات</a>
                </div>
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat">
                <div class="d-flex j-between f-wrap a-center">
                    <p class="title">
                        العملاء
                    </p>
                    <i class="fa-solid fa-users main"></i>
                </div>
                <div class="d-flex j-between f-wrap a-end">
                    <p class="value">
                        {{ $counts['users'] }}
                    </p>
                    <a href="{{ route('admin.clients.index') }}">كلّ العملاء</a>
                </div>
            </div>
            <!-- End Stat -->

            <!-- Start Stat -->
            <div class="stat">
                <div class="d-flex j-between f-wrap a-center">
                    <p class="title">
                        التقييمات
                    </p>
                    <i class="fa-regular fa-star info"></i>
                </div>
                <div class="d-flex j-between f-wrap a-end">
                    <p class="value">
                        {{ $counts['reviews'] }}
                    </p>
                    <a href="{{ route('admin.reviews.index') }}">كلّ التقييمات</a>
                </div>
            </div>
            <!-- End Stat -->

            <!-- Start Stat -->
            <div class="stat">
                <div class="d-flex j-between f-wrap a-center">
                    <p class="title">
                        تكلفة الشحن
                    </p>
                    <i class="fa-solid fa-dollar success"></i>
                </div>
                <div class="d-flex j-between f-wrap a-end">
                    <p class="value">
                        {{ $shippingCost }} د.ت
                    </p>

                </div>
            </div>
            <!-- End Stat -->

        </div>
        <!-- End Quick Stats -->

        @if (count($orders) > 0)
            <!-- Start orders Holder -->
            <div class="holder mt-2 p1 d-flex j-between a-center gap-0-5 f-wrap special-header">
                <h2>أخر الطلبات</h2>
                <a href="{{ route('admin.orders.index') }}">عرض الطلبات</a>
            </div>
            <div class="holder  orders-holder mt-1 mb-2 pt-1 pb-1 ps-1 pe-1 ">
                <div class="table-responsive admin-orders">
                    <table>

                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>المبلغ (د.ت)</th>
                                <th>الحالة </th>
                                <th>التاريخ </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                                    <td> <a
                                            href="{{ route('admin.clients.show', $order->user) }}">{{ $order->customer_name }}</a>
                                    </td>
                                    <td>{{ $order->formattedAmount }}</td>
                                    <td><span
                                            class="status {{ $order->status }} ">{{ __('statuses.' . $order->status) }}</span>
                                    </td>
                                    <td dir="ltr">{{ $order->created_at->format('Y - m - d : H:i') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End orders Holder -->
        @endif


    </section>
@endsection
