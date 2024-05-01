@extends('layouts.client')

@push('token')
    <meta name="token" content="{{ csrf_token() }}">
@endpush

@push('title')
    <title> كتابي - تأكيد الطلب </title>
@endpush

@push('script')
    <script>
        window.user = @json($user);
        window.statesData = @json($states);
        window.cities = @json($cities);
        window.shippingCost = @json($shippingCost);
    </script>
    @vite('resources/js/checkout.js')
    @vite('resources/js/getCities.js')
@endpush


@section('content')
    <main id="checkout">
        <div class="container">

            <h1 class="page-title">تأكيد الطلب</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.checkout') }}"
                currValue="تأكيد الطلب" />

        </div>
        <div class="container">

        </div>
        <div class="container" id="checkout-container">

        </div>
    </main>
@endsection
