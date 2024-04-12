@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الملفّ الشخصي</title>
@endpush
@push('meta')
    <meta content="{{ csrf_token() }}" name="csrf-token">
@endpush
@push('script')
    @vite('resources/js/updateAvatar.js')
@endpush

@section('content')
    <div id="account">
        <section class="content" id="content">
            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>الملفّ الشخصي</h1>


                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.profile.index') }}" currValue="الملفّ الشخصي" />
                </div>


            </div>
            <!-- End Starter Header -->

            <div class="account-wrapper admin-account">
                <div class="img-holder">
                    <img id="avatar-image" src="{{ asset('storage/' . $user->photo) }}" alt="">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-control">
                            <label for="avatar-input"> <i class="fa-solid fa-pen"></i> </label>
                            <input type="file" id="avatar-input">
                        </div>
                    </form>

                    <h2> {{ $user->fullName }} </h2>
                </div>
                <div class="account-info">
                    <a href="{{ route('admin.profile.edit') }}">تعديل</a>
                    <div class="row">
                        <div class="form-control">
                            <label for="email">البريد الالكتروني</label>
                            <input id="email" type="text" name="" readonly value="{{ $user->email }}">
                        </div>
                        <div class="form-control">
                            <label for="phone">الهاتف</label>
                            <input type="text" id="phone" name="" readonly value="{{ $user->phone }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-control">
                            <label for="state">المدينة</label>
                            <input type="text" class="bold" id="state" name="" readonly
                                value="{{ $user->state->name }}">
                        </div>
                        <div class="form-control">
                            <label for="city">المعتمديّة</label>
                            <input type="text" class="bold" name="" id="city" readonly
                                value="{{ $user->city->name }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-control">
                            <label for="address">العنوان</label>
                            <input type="text" class="bold" name="" id="address" readonly
                                value="{{ $user->address }}">
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
