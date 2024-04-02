@extends('layouts.client')
@push('script')
    @vite('resources/js/map.js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endpush
@push('title')
    <title> الرئيسية - اتصل بنا </title>
@endpush

@section('content')
    <main id="contact">


        <div class="container">
            <h1 class="page-title"> اتصل بنا </h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.contact') }}"
                currValue="اتصل بنا" />
        </div>
        <section>
            <h2 class="section-title">
                نسعد بتواصلك معنا
            </h2>
            <div class="container">
                <div class="contact-grid grid">
                    <div class="grid-item">
                        <i class="fa-solid fa-envelope"></i>
                        <p dir="ltr">example@email.com</p>
                        <p dir="ltr">example@email.com</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-phone"></i>
                        <p dir="ltr">+216 00 000 000</p>
                        <p dir="ltr">+216 00 000 000</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <p>هذا النص هو مثال لنص يمكن استبداله في نفس المساحة.</p>
                    </div>
                </div>
            </div>
        </section>

        <div id="map"></div>




    </main>
@endsection
