@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - المخزن</title>
@endpush

@push('script')
    @vite('resources/js/inventory.js')
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-between " id="starter-header">
            <div class="greeting-holder">
                <h1>المخزن</h1>

                <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                    currUrl="{{ route('admin.inventory.index') }}" currValue="المخزن" />
            </div>



        </div>
        <!-- End Starter Header -->

        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder">
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2>تكلفة المخزون (د.ت)</h2>
                    <p>{{ $stockFinanacialStiatistics['stockCost'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-sack-dollar inventory-cost"></i>
                </div>
            </div>
            <!-- End stat item -->
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2>قيمة المخزون (د.ت)</h2>
                    <p>{{ $stockFinanacialStiatistics['stockPrice'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-sack-dollar inventory-value"></i>
                </div>
            </div>
            <!-- End stat item -->
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2> الأرباح المتوقعة (د.ت)</h2>
                    <p>{{ $stockFinanacialStiatistics['expectedEarnings'] }}</p>

                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-sack-dollar inventory-earnings"></i>
                </div>
            </div>
            <!-- End stat item -->
        </div>
        <!-- End Quick Stats Holder -->
        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder mt-2">
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2>كلُّ المخزون</h2>
                    <p>{{ $stockStatistics['booksCount'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-box all"></i>
                </div>
            </div>
            <!-- End stat item -->
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2>المتوفّر</h2>
                    <p>{{ $stockStatistics['inStock'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-square-check in-stock"></i>
                </div>
            </div>
            <!-- End stat item -->
            <!-- Start stat item -->
            <div class="stat-item">
                <div class="title-value-box">
                    <h2>مرحلة التنبيه</h2>
                    <p>{{ $stockStatistics['stockAlert'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-warning stock-alert"></i>
                </div>
            </div>
            <!-- End stat item -->
            <!-- Start stat item -->
            <div class=" stat-item">
                <div class="title-value-box">
                    <h2>غير متوفّر</h2>
                    <p>{{ $stockStatistics['outOfStock'] }}</p>
                </div>
                <div class="icon-holder">
                    <i class="fa-solid fa-xmark out-of-stock"></i>

                </div>
            </div>
            <!-- End stat item -->
        </div>
        <!-- End Quick Stats Holder -->

        <!-- Start Filters -->
        <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
            <div class="filters-form">
                <div class="filters-header">
                    <h2 class="mb-1 form-title">بحث متقدّم</h2>
                </div>
                <div class="filters-body">
                    <form action="{{ route('admin.inventory.filter') }}" method="get" class="form-grid">
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
                                        <option {{ request()->sort == 'highest_price' ? 'selected' : '' }}
                                            value="highest_price">الأغلى</option>

                                        <option {{ request()->sort == 'lowest_price' ? 'selected' : '' }}
                                            value="lowest_price">الأرخص</option>

                                        <option {{ request()->sort == 'highest_cost' ? 'selected' : '' }}
                                            value="highest_cost">الأعلى تكلفة</option>

                                        <option {{ request()->sort == 'lowest_cost' ? 'selected' : '' }}
                                            value="lowest_cost">الأقلّ تكلفة</option>

                                        <option {{ request()->sort == 'highest_quantity' ? 'selected' : '' }}
                                            value="highest_quantity">الأكثر كمّية</option>

                                        <option {{ request()->sort == 'lowest_quantity' ? 'selected' : '' }}
                                            value="lowest_quantity">الأقلّ كمّية</option>
                                        <option {{ request()->sort == 'highest_stock_alert' ? 'selected' : '' }}
                                            value="highest_stock_alert">الأكثر في تنبيه الكمّيّة</option>

                                        <option {{ request()->sort == 'lowest_stock_alert' ? 'selected' : '' }}
                                            value="lowest_stock_alert">الأقلّ في تنبيه الكمّيّة</option>

                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-1 range-statueses-holder">


                            <div class="form-control">
                                <label>حالة الكتاب</label>
                                <div class="statuses-holder ">

                                    <div class="status form-element">
                                        <label for="stock-alert">التنبيه</label>
                                        <input type="checkbox"
                                            {{ in_array('stock-alert', (array) request()->statuses) ? 'checked' : '' }}
                                            id="stock-alert" name="statuses[]" value="stock-alert">
                                    </div>
                                    <div class="status form-element">
                                        <label for="in-stock">متوفّر</label>
                                        <input type="checkbox"
                                            {{ in_array('in-stock', (array) request()->statuses) ? 'checked' : '' }}
                                            id="in-stock" name="statuses[]" value="in-stock">
                                    </div>
                                    <div class="status form-element">
                                        <label for="out-of-stock">غير متوفّر</label>
                                        <input type="checkbox"
                                            {{ in_array('out-of-stock', (array) request()->statuses) ? 'checked' : '' }}
                                            id="out-of-stock" name="statuses[]" value="out-of-stock">
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>
                                    سعر التكلفة
                                    (د.ت)
                                </label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_cost"
                                            value="{{ request()->min_cost }}" step="0.001" placeholder="مثال : 10">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_cost"
                                            value="{{ request()->max_cost }}" step="0.001" placeholder="مثال : 100">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>
                                    السعر
                                    (د.ت)
                                </label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_price"
                                            value="{{ request()->min_price }}" step="0.001" placeholder="مثال : 10">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_price"
                                            value="{{ request()->max_price }}" step="0.001" placeholder="مثال : 100">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row mb-1 ">
                            <div class="form-control">
                                <label>الكمّية</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_quantity"
                                            value="{{ request()->min_quantity }}" placeholder="مثال : 10">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_quantity"
                                            value="{{ request()->max_quantity }}" placeholder="مثال : 100">
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <label>مرحلة التنبيه</label>
                                <div class="range-row">
                                    <div class="range-holder number">
                                        <p>من : </p>
                                        <input class="form-element" type="number" name="min_stock_alert"
                                            value="{{ request()->min_stock_alert }}" placeholder="مثال : 10">
                                    </div>
                                    <div class="range-holder number">
                                        <p>إلى : </p>
                                        <input class="form-element" type="number" name="max_stock_alert"
                                            value="{{ request()->max_stock_alert }}" placeholder="مثال : 100">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-1">
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>التصنيف</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" name="" placeholder="اسم التصنيف"
                                            id="categories-input">
                                    </div>
                                    <div class="choices-wrapper categories-choices">
                                        @foreach ($categories as $category)
                                            <div class="choice">
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                    id="cat-{{ $category->id }}"
                                                    {{ in_array($category->id, (array) request()->categories) ? 'checked' : '' }}>
                                                <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>الكاتب</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" placeholder="اسم الكاتب" name=""
                                            id="authors-input">
                                    </div>
                                    <div class="choices-wrapper authors-choices">
                                        @foreach ($authors as $author)
                                            <div class="choice">
                                                <input type="checkbox" name="authors[]" value="{{ $author->id }}"
                                                    id="author-{{ $author->id }}"
                                                    {{ in_array($author->id, (array) request()->authors) ? 'checked' : '' }}>
                                                <label for="author-{{ $author->id }}">{{ $author->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column">
                                <div class="filter-column-header">
                                    <label>دار النشر</label>

                                </div>
                                <div class="filter-column-wrapper">
                                    <div class="input-holder">
                                        <input type="search" name="" placeholder="اسم دار النشر"
                                            id="publishers-input">
                                    </div>
                                    <div class="choices-wrapper publishers-choices">
                                        @foreach ($publishers as $publisher)
                                            <div class="choice">
                                                <input type="checkbox" name="publishers[]" value="{{ $publisher->id }}"
                                                    id="publisher-{{ $publisher->id }}"
                                                    {{ in_array($publisher->id, (array) request()->publishers) ? 'checked' : '' }}>
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

        @if ($books->count() > 0)
            <!-- Start books Holder -->
            <div class="holder  inventory mt-2 mb-2 pt-1 pb-1 ps-1 pe-1 ">
                <div class="table-responsive admin-inventory products-table">
                    <table>

                        <thead>
                            <tr>
                                <th>إدارة</th>
                                <th>الكتاب</th>
                                <th>الحالة</th>
                                <th>التصنيف</th>
                                <th>سعر التكلفة (د.ت)</th>
                                <th>السعر (د.ت)</th>
                                <th>الكمّية</th>
                                <th>تنبيه الكمّية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>
                                        <ul class="td-actions">
                                            <li>
                                                <button class="modal-controller">
                                                    <i class="fa-solid fa-gear"></i>
                                                </button>

                                                <div class="modal-holder">
                                                    <div class="modal inventory-modal">
                                                        <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                                                            <h2>إدارة المنتج</h2>
                                                            <button class="modal-closer">
                                                                <i class="fa-solid fa-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="manage-form"
                                                                action="{{ route('admin.inventory.manage', $book) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-control mb-1">
                                                                    <label for="operation-type" class="required">نوع
                                                                        العمليّة</label>
                                                                    <div class="select-box">
                                                                        <select name="operation" id="operation-type"
                                                                            class="form-element">
                                                                            <option value="increment">إضافة</option>
                                                                            <option value="decrement">حذف</option>
                                                                        </select>
                                                                    </div>
                                                                    <p class="error-message">هذا الحقل إجباري</p>
                                                                </div>
                                                                <div class="form-control mb-1">
                                                                    <label for="qty" class="required">الكمّية</label>
                                                                    <input type="number" name="quantity"
                                                                        placeholder="مثال : 100 " id="qty">
                                                                    <p class="error-message">هذا الحقل إجباري</p>
                                                                </div>
                                                                <button class="submitBtn"> إرسال </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>

                                        </ul>
                                    </td>
                                    <td class="product-td inventory-td start">
                                        <div class="img-holder">
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('admin.books.show', $book) }}">{{ $book->name }}</a>
                                            <p>{{ $book->author->name }}</p>
                                            <p>{{ $book->publisher->name }}</p>
                                        </div>
                                    </td>
                                    @if ($book->quantity == 0)
                                        <td><span class="status out-of-stock ">غير متوفّر</span></td>
                                    @elseif($book->quantity != 0 && $book->quantity <= $book->stock_alert)
                                        <td><span class="status stock-alert ">مرحلة التنبيه</span></td>
                                    @else
                                        <td><span class="status in-stock ">متوفّر</span></td>
                                    @endif
                                    <td>{{ $book->category->name }} </td>
                                    <td>{{ $book->formattedCostPrice }}</td>
                                    <td>{{ $book->formattedPrice }}</td>
                                    <td>{{ $book->quantity }}</td>
                                    <td>{{ $book->stock_alert }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Start Pagination -->
                {!! $books->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            </div>
            <!-- End Books Holder -->
        @else
            <div class="not-found-wrapper show">
                <i class="fa-solid fa-circle-info"></i>
                <p>لم يتمّ العثور على أيّ نتائج</p>
            </div>
        @endif
    </section>
@endsection
