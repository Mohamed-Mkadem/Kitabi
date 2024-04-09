@extends('layouts.client')

@push('title')
    <title>كتابي - الملفّ الشخصي</title>
@endpush
@push('script')
    @vite('resources/js/updateAvatar.js')
@endpush
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <main id="account">
        <div class="container">

            <h1 class="page-title">الملف الشخصي</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية"
                currUrl="{{ route('client.profile.index') }}" currValue=" الملفّ الشخصي" />

        </div>

        <div class="container">
            <div class="account-wrapper">
                <div class="img-holder">
                    <img id="avatar-image" src="{{ asset('storage/' . $user->photo) }}" alt="">
                    <form action="" method="post" enctype="multipart/form-data" id="avatar-update-form">
                        @csrf

                        <div class="form-control">
                            <label for="avatar-input"> <i class="fa-solid fa-pen"></i> </label>
                            <input type="file" id="avatar-input" name="avatar">
                        </div>

                    </form>

                    <h2> {{ $user->fullName }} </h2>
                </div>
                <div class="account-info">
                    <a href=" {{ route('client.profile.edit') }} ">تعديل</a>
                    <div class="row">
                        <div class="form-control">
                            <label for="email">البريد الالكتروني</label>
                            <input id="email" type="text" readonly value="{{ $user->email }}">
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
                                value=" {{ $user->address }} ">
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection
