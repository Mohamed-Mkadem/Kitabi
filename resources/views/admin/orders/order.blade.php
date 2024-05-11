@extends('layouts.admin')

@push('meta')
    <title>لوحة التحكّم - تفاصيل الطلب</title>
@endpush

@section('content')
    <div id="order">
        <section class="content" id="content">

            <ul class="d-flex f-wrap j-center a-center gap-1 mb-1">
                @if ($order->status == 'pending')
                    <li>
                        <button class="modal-controller deleteBtn">إلغاء</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-solid fa-xmark"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد إلغاء هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="confirmBtn">نعم</button>

                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <button class="modal-controller greenBtn">تأكيد</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.confirm', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class="fa-solid fa-check-double"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد تأكيد هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="greenBtn">نعم</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @elseif($order->status == 'confirmed')
                    <li>
                        <button class="modal-controller deleteBtn">إلغاء</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-solid fa-xmark"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد إلغاء هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="confirmBtn">نعم</button>

                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <button class="modal-controller greenBtn">تأكيد الشحن</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.ship', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class="fa-solid fa-truck-fast"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد تأكيد شحن هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="greenBtn">نعم</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @elseif($order->status == 'shipped')
                    <li>
                        <button class="modal-controller deleteBtn">تأكيد عودة الطلب</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.return', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class="fa-solid fa-rotate-left"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد تأكيد عودة هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="confirmBtn">نعم</button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <button class="modal-controller greenBtn">تأكيد الاستلام</button>
                        <div class="modal-holder">
                            <form action="{{ route('admin.orders.deliver', $order) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class="fa-solid fa-bag-shopping"></i>
                                <p>
                                    هل أنت متأكد من أنّك تريد تأكيد استلام هذا الطلب ؟
                                </p>
                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                    <button class="cancelBtn">تراجع</button>
                                    <button class="greenBtn">نعم</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @endif
            </ul>


            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>تفاصيل الطلب</h1>
                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.orders.show', $order) }}" currValue="تفاصيل الطلب" />
                </div>
            </div>
            <!-- End Starter Header -->

            <div class="holder order-holder transparent no-box-shadow">
                <div class="header">
                    <div class="d-flex j-start a-center gap-1 mb-1">
                        <h1>طلب رقم - #{{ $order->id }}</h1>
                        <span class="status {{ $order->status }}">{{ __('statuses.' . $order->status) }}</span>
                    </div>
                    <div class="d-flex j-start a-center gap-1 f-wrap">

                        <p>تمّ الطلب بتاريخ <span dir="ltr">{{ $order->created_at->format('Y - m - d : H:i') }}</span>
                        </p>
                        <p>قيمة الطلب : <span>{{ $order->formattedAmount }}</span> د.ت </p>
                        <p>قيمة الشحن : <span>{{ $order->formattedShippingCost }}</span> د.ت </p>
                        <p>
                            <a href="{{ route('admin.clients.show', $order->user) }}">{{ $order->customer_name }}</a>
                        </p>

                    </div>

                </div>

                <div class="table-responsive products-table cart holder p1">
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
                                            <img src="{{ $book->image }}" alt="">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('admin.books.show', $book) }}"> {{ $book->name }} </a>
                                            <p> {{ $book->author->name }} </p>
                                            <p> {{ $book->publisher->name }} </p>
                                        </div>
                                    </td>
                                    <td class="price-td">
                                        {{ $book->formattedPrice }}
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

                <div class="row mb-3 f-w">
                    <div class="shippin-info holder col">
                        <div class="col-header">
                            <h2>تفاصيل الشحن</h2>
                        </div>
                        <div class="body">
                            <h3>
                                <i class="fa-solid fa-map-location-dot"></i>
                                العنوان :
                            </h3>
                            <p>
                                {{ $order->shipping_address }}
                            </p>
                            <h3>
                                <i class="fa-solid fa-phone"></i>
                                الهاتف :
                            </h3>
                            <p>
                                <span dir="ltr">{{ $order->customer_phone }}</span>
                            </p>
                        </div>
                    </div>
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
                                @foreach ($order->statusHistories as $history)
                                    <li>
                                        <div class="d-flex a-center gap-1">
                                            <div class="icon-holder">
                                                @if ($history->action == 'order created')
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                @elseif ($history->action == 'order confirmed')
                                                    <i class="fa-solid fa-square-check"></i>
                                                @elseif ($history->action == 'order cancelled')
                                                    <i class="fa-solid fa-xmark"></i>
                                                @elseif ($history->action == 'order shipped')
                                                    <i class="fa-solid fa-truck-fast"></i>
                                                @elseif ($history->action == 'order delivered')
                                                    <i class="fa-solid fa-bag-shopping"></i>
                                                @elseif ($history->action == 'order returned')
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                @endif
                                            </div>
                                            <div class="info">
                                                <h3>{{ __('statuses.' . $history->action) }}</h3>
                                                <p>{{ $history->created_at->format('Y - m - d : H:i') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
