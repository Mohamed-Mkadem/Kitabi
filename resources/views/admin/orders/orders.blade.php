@extends('layouts.admin')

@push('meta')
    <title>لوحة التحكّم - الطلبات</title>
@endpush

@section('content')
    <section class="content" id="content">
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>الطلبات</h1>
                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.orders.index') }}" currValue="الطلبات" />
            </div>
        </div>

        <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
            <div class="filters-form">
                <div class="filters-header">
                    <h2 class="mb-1 form-title">بحث متقدّم</h2>
                </div>
                <div class="filters-body">
                    <form action="{{ route('admin.orders.filter') }}" method="get" class="form-grid">
                        <div class="row mb-1">
                            <div class="form-control">
                                <label for="orderId">رقم الطلب</label>
                                <input class="form-element" type="text" name="search" id="orderId"
                                    placeholder="رقم الطلب" value="{{ request()->search }}">

                            </div>
                            <div class="form-control">
                                <label for="sort-options">الترتيب</label>
                                <div class="select-box">
                                    <select class="form-element" id="sort-options" name="sort">
                                        <option {{ request()->sort == 'newest' ? 'selected' : '' }} value="newest">الأحدث
                                        </option>
                                        <option {{ request()->sort == 'lowest' ? 'selected' : '' }} value="oldest">الأقدم
                                        </option>
                                        <option {{ request()->sort == 'highest_amount' ? 'selected' : '' }}
                                            value="highest_amount">الأغلى</option>
                                        <option {{ request()->sort == 'lowest_amount' ? 'selected' : '' }}
                                            value="lowest_amount">الأرخص</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="form-control">
                                <label>حالة الطلب</label>
                                <div class="statuses-holder">
                                    <div class="status form-element">
                                        <label for="pending">قيد الانتظار</label>
                                        <input type="checkbox"
                                            {{ in_array('pending', (array) request()->statuses) ? 'checked' : '' }}
                                            id="pending" name="statuses[]" value="pending">
                                    </div>
                                    <div class="status form-element">
                                        <label for="delivered">تمّ استلامه</label>
                                        <input type="checkbox"
                                            {{ in_array('delivered', (array) request()->statuses) ? 'checked' : '' }}
                                            id="delivered" name="statuses[]" value="delivered">
                                    </div>
                                    <div class="status form-element">
                                        <label for="shipped">تمّ شحنه</label>
                                        <input type="checkbox"
                                            {{ in_array('shipped', (array) request()->statuses) ? 'checked' : '' }}
                                            id="shipped" name="statuses[]" value="shipped">
                                    </div>


                                    <div class="status form-element">
                                        <label for="cancelled">تمّ إلغاؤه</label>
                                        <input type="checkbox"
                                            {{ in_array('cancelled', (array) request()->statuses) ? 'checked' : '' }}
                                            id="cancelled" name="statuses[]" value="cancelled">
                                    </div>
                                    <div class="status form-element">
                                        <label for="confirmed">تمّ تأكيده</label>
                                        <input type="checkbox"
                                            {{ in_array('confirmed', (array) request()->statuses) ? 'checked' : '' }}
                                            id="confirmed" name="statuses[]" value="confirmed">
                                    </div>
                                    <div class="status form-element">
                                        <label for="returned">تمّ إرجاعه</label>
                                        <input type="checkbox"
                                            {{ in_array('returned', (array) request()->statuses) ? 'checked' : '' }}
                                            id="returned" name="statuses[]" value="returned">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>قيمة الطلب (د.ت)</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_amount" placeholder="مثال : 10"
                                            value="{{ request()->min_amount }}">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_amount"
                                            placeholder="مثال : 100" value="{{ request()->max_amount }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>تاريخ الطلب</label>
                                <div class="range-row">
                                    <div class="range-holder date">
                                        <p>من : </p>
                                        <input class="form-element" type="date" name="min_date"
                                            value="{{ request()->min_date }}">
                                    </div>
                                    <div class="range-holder date">
                                        <p>إلى : </p>
                                        <input class="form-element" type="date" name="max_date"
                                            value="{{ request()->max_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex a-center gap-1 f-wrap mt-2">
                            <button class="submitBtn" type="submit">بحث</button>
                            <button class="resetBtn formHardRestBtn" type="reset">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (count($orders) > 0)
            <!-- Start orders Holder -->
            <div class="holder  orders-holder mt-2 mb-2 pt-1 pb-1 ps-1 pe-1 ">
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
                                    <td> <a href="">{{ $order->customer_name }}</a> </td>
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
                <!-- Start Pagination -->
                {!! $orders->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            </div>
            <!-- End orders Holder -->
        @else
            <div class="not-found-wrapper show">
                <i class="fa-solid fa-circle-info"></i>
                <p>لم يتمّ العثور على أيّ نتائج</p>
            </div>
        @endif
    </section>
@endsection
