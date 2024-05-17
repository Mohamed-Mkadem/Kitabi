@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - العملاء</title>
@endpush

@push('script')
    @vite(['resources/js/getCities.js'])
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>العملاء</h1>
                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.clients.index') }}" currValue="العملاء" />
            </div>
        </div>
        <!-- End Starter Header -->


        <!-- Start Filters -->
        <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
            <div class="filters-form">
                <div class="filters-header">
                    <h2 class="mb-1 form-title">بحث متقدّم</h2>
                </div>
                <div class="filters-body">
                    <form action="{{ route('admin.clients.filter') }}" method="get" class="form-grid">
                        <div class="row mb-1">
                            <div class="form-control">
                                <label for="name">اسم العميل</label>
                                <input class="form-element" type="text" name="search" id="name"
                                    value="{{ request()->search }}" placeholder="اسم العميل">

                            </div>
                            <div class="form-control">
                                <label for="sort-options">الترتيب</label>
                                <div class="select-box">
                                    <select class="form-element" id="sort-options" name="sort">

                                        <option {{ request()->sort == 'newest' ? 'selected' : '' }} value="newest">الأحدث
                                        </option>

                                        <option {{ request()->sort == 'oldest' ? 'selected' : '' }} value="oldest">الأقدم
                                        </option>

                                        <option {{ request()->sort == 'highest_spent' ? 'selected' : '' }}
                                            value="highest_spent">الأكثر إنفاقا</option>

                                        <option {{ request()->sort == 'lowest_spent' ? 'selected' : '' }}
                                            value="lowest_spent">الأقلّ إنفاقا</option>

                                        <option {{ request()->sort == 'highest_orders' ? 'selected' : '' }}
                                            value="highest_orders">الأكثر طلبا</option>

                                        <option {{ request()->sort == 'lowest_orders' ? 'selected' : '' }}
                                            value="lowest_orders">الأقلّ طلبا</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-1 range-statueses-holder">

                            <div class="form-control">
                                <label>اجمالي الإنفاق (د.ت)</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_spent"
                                            value="{{ request()->min_spent }}" placeholder="مثال : 10" step="0.001">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_spent"
                                            value="{{ request()->max_spent }}" placeholder="مثال : 100" step="0.001">
                                    </div>
                                </div>
                            </div>

                            <div class="form-control">
                                <label>الحالة</label>
                                <div class="statuses-holder sm">

                                    <div class="status form-element">
                                        <label for="active">نشط</label>
                                        <input type="checkbox" id="active" name="statuses[]"
                                            {{ in_array('active', (array) request()->statuses) ? 'checked' : '' }}
                                            value="active">
                                    </div>
                                    <div class="status form-element">
                                        <label for="banned">محظور</label>
                                        <input type="checkbox" id="banned" name="statuses[]"
                                            {{ in_array('banned', (array) request()->statuses) ? 'checked' : '' }}
                                            value="banned">
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>عدد الطلبات</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_orders"
                                            value="{{ request()->min_orders }}" placeholder="مثال : 10">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_orders"
                                            value="{{ request()->max_orders }}" placeholder="مثال : 100">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>تاريخ الانضمام</label>
                                <div class="range-row">
                                    <div class="range-holder date">
                                        <p>من : </p>
                                        <input class="form-element" type="date" name="min_date"
                                            value="{{ request()->min_date }}">
                                    </div>
                                    <div class="range-holder date">
                                        <p>إلى : </p>
                                        <input class="form-element" type="date" name="max_date"
                                            value="{{ request()->max_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="form-control">
                                <label for="state-options">الولاية</label>
                                <div class="select-box">
                                    <select id="state-options" name="state_id" class="has-all form-element">
                                        <option value="all" {{ request()->state_id == 'all' ? 'selected' : '' }}>الكلّ
                                        </option>
                                        @if (request()->state_id)
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    @if (request()->state_id == $state->id) @selected(true) @endif>
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
                            </div>
                            <div class="form-control">
                                <label for="cities-options">المدينة</label>
                                <div class="select-box">

                                    <select id="cities-options" name="city_id" class="form-element">

                                        @if (request()->state_id && request()->state_id != 'all')
                                            <option value="all" {{ request()->city_id == 'all' ? 'selected' : '' }}>
                                                الكلّ
                                            </option>
                                            @foreach ($states[request()->state_id - 1]->cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if (request()->city_id == $city->id) @selected(true) @endif>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="all" {{ request()->city_id == 'all' ? 'selected' : '' }}>
                                                الكلّ
                                            </option>
                                        @endif
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex a-center gap-1 f-wrap mt-2">
                            <button class="submitBtn" type="submit">بحث</button>
                            <button class="resetBtn" type="reset">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Filters -->


        @if (count($clients) > 0)
            <!-- Start Clients Holder -->
            <div class="holder  clients-holder mt-2 mb-2 pt-1 pb-1 ps-1 pe-1 ">
                <div class="table-responsive admin-clients">
                    <table>

                        <thead>
                            <tr>
                                <th>المعرّف</th>
                                <th>العميل</th>
                                <th>الولاية - المدينة </th>
                                <th>الحالة</th>
                                <th>عدد الطلبات</th>
                                <th>إجمالي الإنفاق (د.ت)</th>

                                <th>تاريخ الانضمام </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td><a href="{{ route('admin.clients.show', $client) }}">#{{ $client->id }}</a>
                                    </td>
                                    <td> <a href="{{ route('admin.clients.show', $client) }}">{{ $client->fullName }}</a>
                                    </td>
                                    <td>{{ $client->stateCity }}</td>
                                    <td><span
                                            class="status {{ $client->status }} ">{{ __('auth.' . $client->status) }}</span>
                                    </td>
                                    <td>{{ $client->orders_count }}</td>
                                    <td>{{ $client->formattedSpentAmount ?? '0' }}</td>
                                    <td>{{ $client->created_at->format('Y - m - d') }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Start Pagination -->
                {!! $clients->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            </div>
            <!-- End Clients Holder -->
        @else
            <div class="not-found-wrapper show">
                <i class="fa-solid fa-circle-info"></i>
                <p>لم يتمّ العثور على أيّ نتائج</p>
            </div>
        @endif
    </section>
@endsection
