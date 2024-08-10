@extends('layouts.client')

@push('title')
    <title>كتابي - تعديل الملفّ الشخصي</title>
@endpush
@push('script')
    @vite(['resources/js/edit-profile.js', 'resources/js/getCities.js'])
@endpush
@section('content')
    <main id="edit-profile">
        <div class="container">

            <h1 class="page-title">تعديل الحساب</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية"
                currUrl="{{ route('client.profile.edit') }}" currValue="  تعديل الملفّ الشخصي " />

        </div>
        @if (session()->has('success'))
            <div class="alert success show"> {{ session()->get('success') }} </div>
        @endif
        @if (session('status') === 'verification-link-sent')
            <div class="alert success show"> لقد تمّ إرسال رابط تأكيد جديد </div>
        @endif


        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="container">
                <div class="email-verification-wrapper mt-2 mb-2"style="width:min(500px, 90%);">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                        <div>
                            <p class="mb-1">
                                لقد قمت للتوّ بتغيير بريدك الالكتروني, لذلك نرجو أن تقوم بتأكيده من خلال رابط التأكيد الذي
                                تمّ
                                إرساله الأن لبريدك الالكتروني الجديد وذلك للتمكّن من مواصلة الانتفاع بكامل خدمات الموقع بشكل
                                طبيعي
                            </p>
                            <button class="submitBtn">إرسال رابط تأكيد جديد</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="forms-wrapper">
                <div class="account-info-wrapper">
                    <form action="{{ route('client.profile.update') }}" method="post" id="info-form">
                        @csrf
                        @method('PATCH')
                        <h2>تعديل معلومات الحساب</h2>
                        <div class="row">
                            <div class="form-control">
                                <label for="first_name">الإسم</label>
                                <input required type="text" name="first_name" id="first_name" placeholder="الإسم"
                                    value="{{ $user->first_name }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="first_name" />
                            </div>
                            <div class="form-control">
                                <label for="last_name">اللّقب</label>
                                <input required type="text" name="last_name" id="last_name" placeholder="اللّقب"
                                    value="{{ $user->last_name }}">
                                <x-input-error field="last_name" />
                                <p class="error-message">هذا الحقل اجباري</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-control">
                                <label for="email">البريد الالكتروني</label>
                                <input required type="email" name="email" id="email" placeholder="البريد الالكتروني"
                                    value="{{ $user->email }}">
                                <x-input-error field="email" />
                                <p class="error-message">هذا الحقل اجباري</p>
                            </div>
                            <div class="form-control">
                                <label for="phone">الهاتف</label>
                                <input required type="text" name="phone" id="phone" placeholder="الهاتف"
                                    value="{{ $user->phone }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="phone" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-control">
                                <label for="state-options">الولاية</label>
                                <div class="select-box">
                                    <select id="state-options" name="state_id">

                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                @if ($state->id == $user->state_id) @selected(true) @endif>
                                                {{ $state->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <x-input-error field="state_id" />
                                <p class="error-message " id="state-error">هذا الحقل إجباري</p>
                            </div>
                            <div class="form-control">
                                <label for="cities-options">المعتمديّة</label>
                                <div class="select-box">
                                    <select id="cities-options" name="city_id">
                                        @foreach ($user->state->cities as $city)
                                            <option value="{{ $city->id }}"
                                                @if ($city->id == $user->city_id) @selected(true) @endif>
                                                {{ $city->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <x-input-error field="city_id" />
                                <p class="error-message" id="city-error">هذا الحقل إجباري</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-control">
                                <label for="address">العنوان</label>
                                <input required type="text" name="address" id="address" placeholder="العنوان"
                                    value="{{ $user->address }}">
                                <x-input-error field="address" />
                                <p class="error-message">هذا الحقل اجباري</p>
                            </div>
                        </div>

                        <button type="submit" class="submitBtn d-block mb-1 mt-1 "> تحديث </button>


                    </form>
                </div>

                <div class="password-wrapper">
                    <form action="{{ route('password.update') }}" method="post" id="passwords-form">
                        @csrf
                        @method('PUT')
                        <h2>تغيير كلمة السرّ</h2>
                        <div class="row">
                            <div class="form-control">
                                <label for="current-password">كلمة السرّ الحالية</label>
                                <input required type="password" placeholder="كلمة السرّ الحالية" name="current_password"
                                    id="current-password">
                                <x-input-error field="current_password" />
                                <p class="error-message">هذا الحقل إجباري</p>
                            </div>
                            <div class="form-control">
                                <label for="new-password"> كلمة السرّ الجديدة</label>
                                <input required type="password" placeholder="كلمة السرّ الجديدة" name="password"
                                    id="new-password">
                                <x-input-error field="password" />
                                <p class="error-message">هذا الحقل إجباري</p>
                            </div>
                            <div class="form-control">
                                <label for="confirm-password"> تأكيد كلمة السرّ</label>
                                <input required type="password" placeholder=" تأكيد كلمة السرّ" id="confirm-password"
                                    name="password_confirmation">
                                <p class="error-message">هذا الحقل إجباري</p>
                            </div>
                        </div>
                        <button type="submit" class="submitBtn d-block mb-1 mt-1 "> تحديث </button>
                    </form>
                </div>
            </div>

        </div>



    </main>
@endsection
