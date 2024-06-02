@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - الكتب</title>
@endpush

@push('script')
    @vite(['resources/js/books.js', 'resources/js/validate-import.js'])
@endpush

@section('content')
    <section class="content" id="content">

        @include('components.errors')
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>الكتب</h1>
                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.books.index') }}" currValue="الكتب" />
            </div>
            <!-- Start Link  -->
            <a href="{{ route('admin.books.create') }}" class="a add-btn">
                <span>إضافة كتاب</span>
                <i class="fa-solid fa-plus"></i>
            </a>


            <!-- End Link  -->


        </div>
        <!-- End Starter Header -->

        <!-- Start Export / Import Holder -->
        <div class="import-export-holder d-flex a-center gap-1">
            <a href="" class="" id="export-link">
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
                        <h2>استيراد الكتب</h2>
                        <button class="modal-closer">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.books.import') }}" method="post" id="import-form"
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
                                <input type="file" name="file" id="file-input"
                                    accept="image/jpeg image/png, image/jpg, image/svg">
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

        <!-- Start Filters -->
        <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
            <div class="filters-form">
                <div class="filters-header">
                    <h2 class="mb-1 form-title">بحث متقدّم</h2>
                </div>
                <div class="filters-body">
                    <form action="{{ route('admin.books.filter') }}" method="get" class="form-grid" id="filter-form">
                        <div class="row mb-1">
                            <div class="form-control">
                                <label for="name">اسم الكتاب</label>
                                <input class="form-element" type="text" name="search" id="name"
                                    placeholder="اسم الكتاب" value="{{ request()->search }}">

                            </div>
                            <div class="form-control">
                                <label for="sort-options">الترتيب</label>
                                <div class="select-box">
                                    <select class="form-element" id="sort-options" name="sort">
                                        <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>الأحدث
                                        </option>
                                        <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>الأقدم
                                        </option>
                                        <option value="highest_price"
                                            {{ request()->sort == 'highest_price' ? 'selected' : '' }}>
                                            الأغلى</option>
                                        <option value="lowest_price"
                                            {{ request()->sort == 'lowest_price' ? 'selected' : '' }}>
                                            الأرخص</option>
                                        <option value="highest_rate"
                                            {{ request()->sort == 'highest_rate' ? 'selected' : '' }}>
                                            الأعلى تقييما</option>
                                        <option value="lowest_rate"
                                            {{ request()->sort == 'lowest_rate' ? 'selected' : '' }}>
                                            الأقلّ تقييما</option>
                                        <option value="highest_orders"
                                            {{ request()->sort == 'highest_orders' ? 'selected' : '' }}>
                                            الأكثر طلبا</option>
                                        <option value="lowest_orders"
                                            {{ request()->sort == 'lowest_orders' ? 'selected' : '' }}>
                                            الأقلّ طلبا</option>
                                        <option value="highest_quantity"
                                            {{ request()->sort == 'highest_quantity' ? 'selected' : '' }}>الأكثر كمّيّة
                                        </option>
                                        <option value="lowest_quantity"
                                            {{ request()->sort == 'lowest_quantity' ? 'selected' : '' }}>الأقلّ كمّيّة
                                        </option>
                                        <option value="a-z" {{ request()->sort == 'a-z' ? 'selected' : '' }}>أبجدي
                                            تصاعدي</option>
                                        <option value="z-a" {{ request()->sort == 'z-a' ? 'selected' : '' }}>أبجدي
                                            تنازلي</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-1 range-statueses-holder">
                            <div class="form-control">
                                <label>الكمّية</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_quantity"
                                            placeholder="مثال : 10" value="{{ request()->min_quantity }}">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_quantity"
                                            placeholder="مثال : 100" value="{{ request()->max_quantity }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-control">
                                <label>حالة الكتاب</label>
                                <div class="statuses-holder sm">

                                    <div class="status form-element">
                                        <label for="published">منشور</label>
                                        <input {{ in_array('published', (array) request()->statuses) ? 'checked' : '' }}
                                            type="checkbox" id="published" name="statuses[]" value="published">
                                    </div>
                                    <div class="status form-element">
                                        <label for="hidden">غير منشور</label>
                                        <input {{ in_array('hidden', (array) request()->statuses) ? 'checked' : '' }}
                                            type="checkbox" id="hidden" name="statuses[]" value="hidden">
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>السعر (د.ت)</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_price"
                                            placeholder="مثال : 10" value="{{ request()->min_price }}">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_price"
                                            placeholder="مثال : 100" value="{{ request()->max_price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>التقييم</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_rate"
                                            value="{{ request()->min_rate }}" placeholder="مثال : 10" step="0.01">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_rate"
                                            value="{{ request()->max_rate }}" placeholder="مثال : 100" step="0.01">
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
                                            placeholder="مثال : 10" value="{{ request()->min_orders }}">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_orders"
                                            placeholder="مثال : 100" value="{{ request()->max_orders }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>تاريخ الإضافة</label>
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
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>التصنيفات</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" name="" placeholder="اسم التصنيف"
                                            id="categories-input">
                                    </div>
                                    <div class="choices-wrapper categories-choices">
                                        @foreach ($categories as $category)
                                            <div class="choice">
                                                <input
                                                    {{ in_array($category->id, (array) request()->categories) ? 'checked' : '' }}
                                                    type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                    id="cat-{{ $category->id }}">
                                                <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>المؤلّفون</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" placeholder="اسم المؤلّف" name=""
                                            id="authors-input">
                                    </div>
                                    <div class="choices-wrapper authors-choices">
                                        @foreach ($authors as $author)
                                            <div class="choice">
                                                <input
                                                    {{ in_array($author->id, (array) request()->authors) ? 'checked' : '' }}
                                                    type="checkbox" name="authors[]" value="{{ $author->id }}"
                                                    id="author-{{ $author->id }}">
                                                <label for="author-{{ $author->id }}">{{ $author->name }}</label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>دور النشر</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" name="" placeholder="اسم دار النشر"
                                            id="publishers-input">
                                    </div>
                                    <div class="choices-wrapper publishers-choices">
                                        @foreach ($publishers as $publisher)
                                            <div class="choice">
                                                <input
                                                    {{ in_array($publisher->id, (array) request()->publishers) ? 'checked' : '' }}
                                                    type="checkbox" name="publishers[]" value="{{ $publisher->id }}"
                                                    id="publisher-{{ $publisher->id }}">
                                                <label
                                                    for="publisher-{{ $publisher->id }}">{{ $publisher->name }}</label>
                                            </div>
                                        @endforeach

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
        <!-- End Filters -->


        <div class="results-container">
            @if (count($books) > 0)
                <!-- Start Products -->
                <div class="products-grid  grid mt-3">
                    @foreach ($books as $book)
                        <!-- Start Product -->
                        <div class="product">
                            <div class="product-header">
                                <p class="status {{ $book->status == 'hidden' ? 'hidden' : '' }}">
                                    {{ $book->status == 'hidden' ? 'غير منشور' : 'منشور' }}
                                </p>
                                <div class="top-bar-info">
                                    <p class="rate">
                                        <span>{{ $book->rate }}</span>
                                        <i class="fa-solid fa-star"></i>
                                    </p>
                                    <p class="quantity">
                                        <span>{{ $book->quantity }}</span>
                                        <i class="fa-solid fa-warehouse"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="img-holder">
                                {{-- <img loading="lazy" src="{{ $book->image }}" alt=""> --}}
                                <img loading="lazy" src="{{ asset('storage/' . $book->image) }}" alt="">
                            </div>
                            <div class="product-info">

                                <p class="category">{{ $book->category->name }}</p>
                                <h3 class="title"><a href="{{ route('admin.books.show', $book) }}">
                                        {{ $book->name }}</a></h3>
                                <p class="price"><span> {{ $book->formattedPrice }} </span> د.ت</p>
                                <p class="author"> {{ $book->author->name }}</p>
                                <p class="publisher"> {{ $book->publisher->name }} </p>
                            </div>
                            <div class="meta-data">
                                <p>
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                    {{ $book->order_items_sum_quantity ?? '0' }}
                                </p>
                                <p>
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $book->created_at->format('Y-m-d') }}
                                </p>
                            </div>
                        </div>
                        <!-- End Product -->
                    @endforeach
                </div>
                <!-- End Products -->
                <!-- Start Pagination -->
                {!! $books->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            @else
                <!-- Start not found -->
                <div class="not-found-wrapper show">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>لم يتمّ العثور على أيّ نتائج</p>
                </div>
                <!-- End not found -->
            @endif
        </div>
    </section>
@endsection
