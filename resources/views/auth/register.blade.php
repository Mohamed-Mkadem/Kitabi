@extends('layouts.client')

@push('title')
    <title>كتابي - حساب جديد</title>
@endpush

@push('script')
    @vite(['resources/js/validate-signup.js', 'resources/js/getCities.js'])
@endpush

@section('content')
    <main id="authentication">
        <div class="container">

            <h1 class="page-title">حساب جديد</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('register') }}"
                currValue="حساب جديد" />

            <div class="container">
                <div class="auth-wrapper">
                    <form action="{{ route('register') }}" method="post" id="signup-form">
                        @csrf
                        <div class="row">
                            <div class="form-control">
                                <label for="first_name" class="required">الإسم</label>
                                <input required value="{{ old('first_name', '') }}" type="text" name="first_name"
                                    id="first_name" placeholder="الإسم">
                                <x-input-error field="first_name" />
                                <p class="error-message "> هذا الحقل إحباري </p>
                            </div>
                            <div class="form-control">
                                <label for="last_name" class="required">اللّقب</label>
                                <input required type="text" value="{{ old('last_name', '') }}" name="last_name"
                                    id="last_name" placeholder="اللّقب">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="last_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="email" class="required">البريد الالكتروني</label>
                                <input required type="email" name="email" id="email" placeholder="البريد الالكتروني"
                                    value="{{ old('email', '') }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="phone" class="required">الهاتف</label>
                                <input required type="text" name="phone" id="phone" placeholder="الهاتف"
                                    value="{{ old('phone', '') }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="phone" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="password" class="required">كلمة السر</label>
                                <input required type="password" name="password" id="password" placeholder="كلمة السر">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="password" />
                            </div>
                            <div class="form-control">
                                <label for="confirm-password" class="required">تأكيد كلمة السر</label>
                                <input required type="password" name="password_confirmation" id="confirm-password"
                                    placeholder="تأكيد كلمة السر">

                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="password_confirmation" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="state-options" class="required">الولاية</label>
                                <div class="select-box">
                                    <select id="state-options" name="state">


                                        @if (old('state'))
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    @if (old('state') == $state->id) @selected(true) @endif>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <p class="error-message " id="state-error">هذا الحقل إجباري</p>
                                <x-input-error field="state" />
                            </div>
                            <div class="form-control">
                                <label for="cities-options" class="required">المعتمديّة</label>
                                <div class="select-box">

                                    <select id="cities-options" name="city">

                                        @if (old('city'))
                                            @foreach ($states[old('state') - 1]->cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if (old('city') == $city->id) @selected(true) @endif>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($states[0]->cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <p class="error-message" id="city-error">هذا الحقل إجباري</p>
                                <x-input-error field="city" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-control">
                                <label for="address" class="required">العنوان</label>
                                <input type="text" name="address" id="address" placeholder="العنوان"
                                    value="{{ old('address', '') }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="address" />
                            </div>
                        </div>

                        <button type="submit" class="submitBtn d-block mb-1 mt-1 m-auto">إنشاء حساب</button>
                        <a href="{{ route('login') }}" class="d-block m-auto t-center">هل لديك حساب بالفعل ؟ تسجيل
                            الدخول</a>

                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection
