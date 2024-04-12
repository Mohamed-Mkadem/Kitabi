@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - تعديل الملفّ الشخصي</title>
@endpush
@push('script')
    @vite(['resources/js/edit-profile.js', 'resources/js/getCities.js'])
@endpush

@section('content')
    <div id="edit-profile">
        <section class="content" id="content">
            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>تعديل الحساب</h1>


                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.profile.edit') }}" currValue="تعديل الملفّ الشخصي" />
                </div>



            </div>
            <!-- End Starter Header -->

            <div class="forms-wrapper admin-account">
                <div class="account-info-wrapper">
                    <form action="{{ route('admin.profile.update') }}" method="post" id="info-form" novalidate>
                        @csrf
                        @method('PATCH')
                        <h2>تعديل معلومات الحساب</h2>
                        <div class="row">
                            <div class="form-control">
                                <label for="first_name">الإسم</label>
                                <input required type="text" name="first_name" id="first_name" placeholder="الإسم"
                                    value="{{ $user->first_name }}">
                                <x-input-error field="first_name" />
                                <p class="error-message ">هذا الحقل اجباري</p>
                            </div>
                            <div class="form-control">
                                <label for="last_name">اللّقب</label>
                                <input required type="text" name="last_name" id="last_name" placeholder="اللّقب"
                                    value="{{ $user->last_name }}">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="last_name" />

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-control">
                                <label for="email">البريد الالكتروني</label>
                                <input required type="email" name="email" id="email" value="{{ $user->email }}"
                                    placeholder="البريد الالكتروني">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="email" />
                            </div>
                            <div class="form-control">
                                <label for="phone">الهاتف</label>
                                <input required type="text" name="phone" id="phone" placeholder="الهاتف"
                                    value="{{ $user->phone }}">
                                <x-input-error field="phone" />
                                <p class="error-message">هذا الحقل اجباري</p>
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
                                <input required type="text" name="address" value="{{ $user->address }}" id="address"
                                    placeholder="العنوان">
                                <p class="error-message">هذا الحقل اجباري</p>
                                <x-input-error field="address" />
                            </div>
                        </div>

                        <button type="submit" class="submitBtn d-block mb-1 mt-1 "> تحديث </button>


                    </form>
                </div>

                <div class="password-wrapper">
                    <form action="{{ route('password.update') }}" method="post" id="passwords-form" novalidate>
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

        </section>
    </div>
@endsection
