@extends('layouts.client')

@push('title')
    <title> كتابي - السلّة </title>
@endpush

@push('script')
    @vite('resources/js/cartPage.js')
@endpush

@section('content')
    <main id="cart">
        <div class="container">

            <h1 class="page-title">السلّة</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.cart') }}"
                currValue="السلّة" />


        </div>
        <div id="errors-container" class="container"></div>
        <div class="container" id="cart-container">
        </div>
    </main>
@endsection
