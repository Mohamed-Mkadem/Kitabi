@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الناشرون</title>
@endpush

@push('script')
    @vite(['resources/js/validate-auth-cat-pub.js', 'resources/js/publishers.js', 'resources/js/validate-import.js'])
@endpush


@section('content')

    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>الناشرون</h1>
                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.publishers.index') }}" currValue="الناشرون" />
            </div>

            <button class="starter-header-btn add-btn modal-controller" id="add-btn">
                إضافة ناشر
                <i class="fa-solid fa-plus"></i>
            </button>
            <div class="modal-holder ">
                <div class="modal new-auth-cat-pub-modal">
                    <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                        <h2>إضافة ناشر</h2>
                        <button class="modal-closer">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.publishers.store') }}" method="post" id="new-record-form">
                        @csrf
                        <div class="form-control mb-1">
                            <label for="name-input" class="required">اسم الناشر</label>
                            <input type="text" name="name" id="name-input" placeholder="اسم الناشر">
                            <p class="error-message ">هذا الحقل إجباري</p>
                        </div>

                        <button type="submit" class="submitBtn mt-1">إضافة</button>
                    </form>
                </div>
            </div>


        </div>
        <!-- End Starter Header -->

        @include('components.error-messages')

        <!-- Start Export / Import Holder -->
        <div class="import-export-holder d-flex a-center gap-1">
            <a href="{{ route('admin.publishers.export') }}" id="export-link">
                تصدير
                <i class="fa-solid fa-file-arrow-down"></i>
            </a>
            <button class="modal-controller" id="export-btn">
                استيراد
                <i class="fa-solid fa-file-import"></i>
            </button>
            <div class="modal-holder ">
                <div class="modal new-auth-cat-pub-modal">
                    <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                        <h2>استيراد الناشرين</h2>
                        <button class="modal-closer">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.publishers.import') }}" method="post" id="import-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-control">
                            <label class="form-label required">
                                الملفّ
                                : </label>
                            <div class="drop-zone ">
                                <label for="file-input" class="drop-zone-label form-label">
                                    <i class="fa-solid fa-cloud-arrow-up d-block"></i>
                                    <p>اضغط هنا لاختيار الملفّ</p>
                                    <p>الامتدادات المسموح بها هي xlsx, csv, xls</p>
                                </label>
                                <input type="file" name="file" id="file-input">
                            </div>
                            <p class="error-message" id="file-input-error-message">هذا الحقل إجباري</p>
                            <div class="upload-area d-flex j-start a-center ">
                                <i class="fa-solid fa-file-image"></i>
                                <div class="file-info">
                                    <p class="file-name">
                                        FileName.png </p>
                                    <p class="file-size">485 KB</p>

                                </div>
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>

                        <button type="submit" class="submitBtn mt-1">استيراد</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Export / Import Holder -->

        <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
            <div class="filters-form">
                <div class="filters-header">
                    <h2 class="mb-1 form-title">بحث متقدّم</h2>
                </div>
                <div class="filters-body">
                    <form action="{{ route('admin.publishers.filter') }}" method="get" class="form-grid" id="filter-form">
                        <div class="row mb-1">
                            <div class="form-control">
                                <label for="name">اسم الناشر</label>
                                <input class="form-element" type="text" name="search" id="name"
                                    placeholder="اسم الناشر" value="{{ request()->query('search') }}">

                            </div>
                            <div class="form-control">
                                <label for="sort-options">الترتيب</label>
                                <div class="select-box">
                                    <select class="form-element" id="sort-options" name="sort">
                                        <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>الأحدث
                                        </option>
                                        <option value="oldest"{{ request()->sort == 'oldest' ? 'selected' : '' }}>الأقدم
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>عدد الكتب</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_books_count"
                                            placeholder="مثال : 10" value="{{ request('min_books_count') }}">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_books_count"
                                            placeholder="مثال : 100" value="{{ request('max_books_count') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>تاريخ الإضافة</label>
                                <div class="range-row">
                                    <div class="range-holder date">
                                        <p>من : </p>
                                        <input class="form-element" type="date" name="min_date"
                                            value="{{ request()->query('min_date') }}">
                                    </div>
                                    <div class="range-holder date">
                                        <p>إلى : </p>
                                        <input class="form-element" type="date" name="max_date"
                                            value="{{ request()->query('max_date') }}">
                                    </div>
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


        <div class="results-container">
            @if (count($publishers) > 0)
                <div class="grid auth-cat-pub-grid">
                    @foreach ($publishers as $publisher)
                        <!-- Start publisher -->
                        <div class="card auth-cat-pub">
                            <div class="card-header d-flex j-end">
                                <button class="action-controller">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="actions-holder">
                                    <li>
                                        <button class="action-edit-btn modal-controller">تعديل</button>
                                        <div class="modal-holder ">
                                            <div class="modal new-auth-cat-pub-modal">
                                                <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                                                    <h2>تعديل الناشر</h2>
                                                    <button class="modal-closer">
                                                        <i class="fa-solid fa-close"></i>
                                                    </button>
                                                </div>

                                                <form action="{{ route('admin.publishers.update', $publisher) }}"
                                                    method="post" class="edit-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-control mb-1">
                                                        <label for="name-input" class="required">اسم الناشر</label>
                                                        <input type="text" name="name"
                                                            value="{{ $publisher->name }}" placeholder="اسم الناشر">
                                                        <p class="error-message ">هذا الحقل إجباري</p>
                                                    </div>

                                                    <button type="submit" class="submitBtn mt-1">تعديل

                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="action-delete-btn modal-controller">حذف</button>
                                        <div class="modal-holder ">
                                            <form action="{{ route('admin.publishers.destroy', $publisher) }}"
                                                method="post" class="modal t-center confirm-form">
                                                @csrf
                                                @method('DELETE')
                                                <i class=" fa-solid fa-trash"></i>
                                                <p>
                                                    هل أنت متأكد من أنّك تريد حذف هذا الناشر ؟
                                                </p>
                                                <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                                    <button class="cancelBtn">إلغاء</button>
                                                    <button class="confirmBtn">نعم</button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h3>{{ $publisher->name }}</h3>
                                <div class="meta-data ">
                                    <p class="count">
                                        <i class="fa-solid fa-book"></i>
                                        <span>{{ $publisher->books_count }}</span>
                                    </p>
                                    <p class="date">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $publisher->created_at->format('d - m - Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- End publisher -->
                    @endforeach

                </div>
                <!-- Start Pagination -->
                {!! $publishers->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            @else
                <div class="not-found-wrapper show">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>لم يتمّ العثور على أيّ نتائج</p>
                </div>
            @endif
        </div>


    </section>
@endsection
