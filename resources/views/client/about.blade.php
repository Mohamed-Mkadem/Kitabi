@extends('layouts.client')
@push('script')
    @vite('resources/js/map.js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endpush
@push('title')
    <title> الرئيسية - من نحن </title>
@endpush

@section('content')
    <main id="about">

        <div class="container">
            <h1 class="page-title">من نحن</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.about') }}"
                currValue="من نحن" />
        </div>

        <div class="container">
            <div class="row">
                <div class="col info">
                    <h2>عنوان هنا</h2>
                    <p>
                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث
                        يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها
                        التطبيق.
                    </p>
                </div>
                <div class="col img-holder">
                    <img loading="lazy" src="https://picsum.photos/500" alt="">
                </div>
            </div>
            <div class=" row reverse">

                <div class="col info">
                    <h2>عنوان هنا</h2>
                    <p>
                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                        حيث
                        يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها
                        التطبيق.
                    </p>
                </div>
                <div class="col img-holder">
                    <img loading="lazy" src="https://picsum.photos/500" alt="">
                </div>
            </div>
            <div class=" row">

                <div class="col info">
                    <h2>عنوان هنا</h2>
                    <p>
                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                        العربى، حيث
                        يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى
                        يولدها
                        التطبيق.
                    </p>
                </div>
                <div class="col img-holder">
                    <img loading="lazy" src="https://picsum.photos/500" alt="">
                </div>
            </div>
        </div>

        <div id="map">
        </div>


        <section class="why-us">
            <h2 class="section-title">لماذا كتابي ؟</h2>
            <div class="container">
                <div class="why-us-grid grid">
                    <div class="grid-item">
                        <i class="fa-regular fa-square-check"></i>
                        <p>طبعات فاخرة ومميزة</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-book"></i>
                        <p>إصدارات حديثة ومتنوعة</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-truck-fast fa-flip-horizontal"></i>
                        <p>توصيل لكامل الجمهورية</p>
                    </div>
                </div>
            </div>

        </section>

    </main>
@endsection
