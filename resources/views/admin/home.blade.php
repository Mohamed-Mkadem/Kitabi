@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الرئيسية</title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>مرحبا كتابي</h1>
                <p class="today-stats">هذه بعض الإحصائيات السريعة</p>

                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.home') }}" currValue="الرئيسية" />

            </div>
            <!-- Start Link  -->
            <a href="{{ route('client.home') }}" class="action-btn d-block">
                <span>زيارة المتجر</span>
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>

            <!-- End Link  -->


        </div>
        <!-- End Starter Header -->


    </section>
@endsection
