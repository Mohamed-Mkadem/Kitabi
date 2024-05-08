@extends('layouts.client')

@push('title')
    <title>كتابي - تسجيل الدخول</title>
@endpush
@push('script')
    @vite('resources/js/validate-login.js')
@endpush


@section('content')
    <main id="authentication">
        <div class="container">

            <h1 class="page-title">تسجيل الدخول</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('login') }}"
                currValue=" تسجيل الدخول" />

            <div class="container">
                <div class="auth-wrapper login">
                    <form action="{{ route('login') }}" method="post" id="login-form">
                        @csrf
                        <div class="row">
                            <div class="form-control">
                                <label for="email" class="required">البريد الالكتروني</label>
                                <input required type="email" name="email" id="email"
                                    placeholder="البريد الالكتروني">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="password" class="required">كلمة السر</label>
                                <input required type="password" name="password" id="password" placeholder="كلمة السر">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="password" />
                            </div>

                        </div>
                        <button type="submit" class="submitBtn d-block mb-1 mt-1 m-auto">تسجيل الدخول</button>
                        <a href="{{ route('password.request') }}" class="d-block mb-1 m-auto t-center">إعادة تعيين كلمة
                            السرّ</a>
                        <a href="{{ route('register') }}" class="d-block m-auto t-center"> ليس لديك حساب ؟ أنشئ حسابا الأن
                        </a>

                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection
