@extends('layouts.client')

@push('meta')
    <title>كتابي - تفاصيل الطلب</title>
@endpush


@section('content')
    <main id="order">
        <div class="container">

            <h1 class="page-title">تفاصيل الطلب</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية"
                currUrl="{{ route('client.orders.show', $order) }}" currValue=" تفاصيل الطلب" />

        </div>

        <div class="container">

            @if ($order->status == 'pending')
                <div class="message info show  mt-1" style="margin-bottom: -1em;">
                    <p>
                        سيتمّ الاتصال بكم قريبا على رقم الهاتف الخاص بكم لتأكيد الطلب. شكرا
                    </p>
                </div>
            @endif

            <div class="holder order-holder no-box-shadow">
                <div class="header">
                    <div class="d-flex j-start a-center gap-1 mb-1">
                        <h1>طلب رقم - #{{ $order->id }}</h1>
                        <span class="status {{ $order->status }}">{{ __('statuses.' . $order->status) }}</span>
                    </div>
                    <div class="d-flex j-start a-center gap-1">
                        <p>تمّ الطلب بتاريخ <span dir="ltr">{{ $order->created_at->format('Y - m - d : h:i') }}</span>
                        </p>
                        <p>قيمة الطلب : <span>{{ $order->formattedAmount }}</span> د.ت </p>

                    </div>

                </div>

                <div class="table-responsive products-table cart">
                    <table>
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th> السعر (د.ت) </th>
                                <th>الكمّية</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->books as $book)
                                <!-- Start row -->
                                <tr>
                                    <td class="product-td start two">
                                        <div class="img-holder">
                                            <img src="{{ $book->pivot->image }}" alt="">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('client.shop.book', $book) }}">{{ $book->name }}</a>
                                            <p>{{ $book->author->name }}</p>
                                            <p>{{ $book->publisher->name }}</p>

                                        </div>
                                    </td>
                                    <td class="price-td">
                                        {{ $book->pivot->formattedPrice }}
                                    </td>
                                    <td>
                                        {{ $book->pivot->quantity }}
                                    </td>
                                    <td class="price-td">

                                        {{ $book->pivot->formattedSubTotal }}
                                    </td>
                                </tr>
                                <!-- End row -->
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="row mb-3">
                    <div class="notes holder col">
                        <div class="col-header">

                            <h2>ملاحظات العميل</h2>
                        </div>
                        <div class="body">
                            @if ($order->note)
                                <p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد
                                    الحروف التى يولدها التطبيق. </p>
                            @else
                                <p>لم يترك العميل أي ملاحظات</p>
                            @endif
                        </div>
                    </div>
                    <div class="order-history holder col">
                        <div class="col-header">

                            <h2>تاريخ الطلب</h2>
                        </div>
                        <div class="body">
                            <ul class="statuses">
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </div>
                                        <div class="info">
                                            <h3>تمّ الإنشاء</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-square-check"></i>
                                        </div>
                                        <div class="info">
                                            <h3>تمّ التأكيد</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </div>
                                        <div class="info">
                                            <h3>تمّ الشحن</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="info">

                                            <h3>تمّ الاستلام</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>

                                    </div>

                                </li>
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </div>
                                        <div class="info">

                                            <h3>تمّ الإرجاع</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex a-center gap-1">
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="info">
                                            <h3>تمّ الإلغاء</h3>
                                            <p>25 - 04 - 2023 17:35</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection
