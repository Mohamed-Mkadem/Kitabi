@extends('layouts.client')

@push('meta')
    <title>كتابي - الطلبات</title>
@endpush


@section('content')
    <main id="orders">
        <div class="container">

            <h1 class="page-title">الطلبات</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية"
                currUrl="{{ route('client.orders.index') }}" currValue=" الطلبات" />
        </div>

        <div class="container">
            @if (count($orders) > 0)
                <!-- Start orders Holder -->
                <div class="holder orders-holder mt-2 mb-2 ">
                    <div class="table-responsive client-orders">
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
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('client.orders.show', $order) }}">#{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->formattedAmount }}</td>
                                        <td><span
                                                class="status {{ $order->status }} ">{{ __('statuses.' . $order->status) }}</span>
                                        </td>
                                        <td dir="ltr">{{ $order->created_at->format('Y - m - d : h:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End orders Holder -->
                <!-- Start Pagination -->
                {!! $orders->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            @else
                <div class="not-found-wrapper show">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>لم يتمّ العثور على أيّ نتائج</p>
                </div>
            @endif
        </div>




    </main>
@endsection
