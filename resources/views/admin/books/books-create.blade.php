@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - كتاب جديد</title>
@endpush

@vite('resources/js/book.js')

@section('content')
    <section class="content" id="content">


        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>كتاب جديد</h1>
                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.books.create') }}" currValue="كتاب جديد" />
            </div>
        </div>
        <!-- End Starter Header -->

        <div class="holder pt-1 pb-1 pe-1 ps-1">
            <form action="{{ route('admin.books.store') }}" method="post" class="form-grid" enctype="multipart/form-data"
                id="book-form" novalidate>
                @csrf
                <div class="row mb-1">
                    <div class="form-control">
                        <label for="name-input" class="required">اسم الكتاب</label>
                        <input class="form-element" required type="text" name="name" id="name-input"
                            placeholder="اسم الكتاب" value="{{ old('name') }}">
                        <p class="error-message name-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="name" />
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="form-control">
                        <label for="description-input" class="required">وصف الكتاب</label>
                        <textarea id="description-input" name="description" placeholder="ضع وصفا مناسبا للكتاب هنا" required
                            class="form-element">{{ old('description') }}</textarea>
                        <p class="error-message description-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="description" />
                    </div>
                </div>
                <div class="row mb-1 ">
                    <div class="form-control">
                        <label class="required">حالة الكتاب</label>
                        <div class="statuses-holder ">

                            <div class="status form-element">
                                <label for="published">منشور</label>
                                <input {{ old('status') == 'published' ? 'checked' : '' }} type="radio" id="published"
                                    name="status" value="published">
                            </div>

                            <div class="status form-element">
                                <label for="hidden">غير منشور</label>
                                <input {{ old('status') == 'hidden' ? 'checked' : '' }} type="radio" id="hidden"
                                    name="status" value="hidden">
                            </div>

                        </div>
                        <p class="error-message status-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="status" />
                    </div>
                </div>


                <div class="row mb-1 ">
                    <div class="form-control">
                        <label class="required">
                            سعر التكلفة
                            (ملّيم)
                        </label>
                        <input class="form-element" type="number" id="cost-price-input" placeholder="مثال : 10"
                            name="cost_price" value="{{ old('cost_price') }}">
                        <p class="error-message cost-price-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="cost_price" />
                    </div>
                    <div class="form-control">
                        <label class="required">
                            سعر البيع
                            (ملّيم)
                        </label>
                        <input class="form-element" type="number" id="price-input" placeholder="مثال : 10" name="price"
                            value="{{ old('price') }}">
                        <p class="error-message price-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="price" />
                    </div>
                </div>
                <div class="row mb-1 ">
                    <div class="form-control">
                        <label class="required">
                            الكمّية
                        </label>
                        <input class="form-element" type="number" id="quantity-input" placeholder="مثال : 10"
                            name="quantity" value="{{ old('quantity') }}">
                        <p class="error-message quantity-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="quantity" />
                    </div>
                    <div class="form-control">
                        <label class="required">
                            التنبيه
                        </label>
                        <input class="form-element" type="number" id="stock-alert-input" placeholder="مثال : 10"
                            name="stock_alert" value="{{ old('stock_alert') }}">
                        <p class="error-message stock-alert-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="stock_alert" />
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="form-control">
                        <label class="form-label required">
                            صورة الكتاب
                            : </label>
                        <div class="drop-zone ">
                            <label for="file-input" class="drop-zone-label form-label">
                                <i class="fa-solid fa-cloud-arrow-up d-block"></i>
                                <p>اضغط هنا لاختيار الصورة</p>
                                <p>الامتدادات المسموح بها هي jpg, png</p>
                                <p>أبعاد الصورة : 750 * 500</p>
                            </label>
                            <input type="file" name="image" id="file-input" class="required">

                        </div>
                        <p class="error-message" id="file-input-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="image" />
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
                </div>
                <div class="row mb-1">
                    <div class="filter-column">
                        <div class="filter-column-header">
                            <label class="required">التصنيف</label>
                        </div>
                        <div class="filter-column-wrapper">
                            <div class="input-holder">
                                <input type="search" name="" placeholder="اسم التصنيف" id="categories-input">
                            </div>
                            <div class="choices-wrapper categories-choices">
                                @foreach ($categories as $category)
                                    <div class="choice">
                                        <input type="radio" name="category_id" value="{{ $category->id }}"
                                            id="cat-{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'checked' : '' }}>
                                        <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <p class="error-message category-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="category_id" />
                    </div>
                    <div class="filter-column">
                        <div class="filter-column-header">
                            <label class="required">المؤلّف</label>

                        </div>
                        <div class="filter-column-wrapper">
                            <div class="input-holder">
                                <input type="search" placeholder="اسم المؤلّف" name="" id="authors-input">
                            </div>
                            <div class="choices-wrapper authors-choices">
                                @foreach ($authors as $author)
                                    <div class="choice">
                                        <input type="radio" name="author_id" value="{{ $author->id }}"
                                            id="author-{{ $author->id }}"
                                            {{ old('author_id') == $author->id ? 'checked' : '' }}>
                                        <label for="author-{{ $author->id }}">{{ $author->name }}</label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <p class="error-message author-error-message">هذا الحقل إجباري</p>
                        <x-input-error field="author_id" />
                    </div>
                    <div class="filter-column">
                        <div class="filter-column-header">
                            <label class="required">دار النشر</label>
                        </div>
                        <div class="filter-column-wrapper">
                            <div class="input-holder">
                                <input type="search" name="" placeholder="اسم دار النشر" id="publishers-input">
                            </div>
                            <div class="choices-wrapper publishers-choices">
                                @foreach ($publishers as $publisher)
                                    <div class="choice">
                                        <input type="radio" name="publisher_id" value="{{ $publisher->id }}"
                                            id="publisher-{{ $publisher->id }}"
                                            {{ old('publisher_id') == $publisher->id ? 'checked' : '' }}>
                                        <label for="publisher-{{ $publisher->id }}">{{ $publisher->name }}</label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <x-input-error field="publisher_id" />
                        <p class="error-message publisher-error-message">هذا الحقل إجباري</p>

                    </div>
                </div>
                <div class="d-flex a-center gap-1 f-wrap mt-2">
                    <button class="submitBtn" type="submit">إضافة الكتاب</button>
                </div>
            </form>
        </div>


    </section>
@endsection
