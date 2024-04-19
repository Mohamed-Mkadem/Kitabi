@extends('layouts.admin')

@push('title')
    <title>كتابي - تفاصيل الكتاب</title>
@endpush


@section('content')
    <section class="content" id="content">
        <div id="book">
            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>تفاصيل الكتاب</h1>

                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.books.show', $book) }}" currValue="تفاصيل الكتاب" />
                </div>
                <div class="d-flex j-center a-stretch gap-1 f-wrap">


                    <a href="{{ route('admin.books.edit', $book) }}" class="action-btn d-block">
                        <span>تعديل</span>
                        <i class="fa-solid fa-pen"></i>
                    </a>


                    <button class="modal-controller deleteBtn">
                        حذف
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal-holder">
                        <form action="{{ route('admin.books.destroy', $book) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('DELETE')
                            <i class=" fa-solid fa-trash"></i>
                            <p>
                                هل أنت متأكد من أنّك تريد حذف هذا الكتاب ؟
                            </p>
                            <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                <button class="cancelBtn">إلغاء</button>
                                <button class="confirmBtn">نعم</button>
                            </div>
                        </form>
                    </div>

                </div>


            </div>
            <!-- End Starter Header -->

            <div class="product-holder admin-book-page">
                <div class="product no-shadow admin-dashboard">
                    <div class="product-header">

                        <div class="top-bar-info">

                            <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }}">
                                {{ $book->isOutOfStock() ? 'غير متوفّر' : 'متوفّر' }}</p>
                        </div>
                    </div>
                    <div class="img-holder">
                        {{-- <img loading="lazy" src="{{ $book->image }}" alt=""> --}}
                        <img loading="lazy" src="{{ asset('storage/' . $book->image) }}" alt="">
                    </div>
                    <div class="product-info">

                        <p class="category">{{ $book->category->name }}</p>
                        <h3 class="title"> {{ $book->name }} </h3>
                        <div class="rate-holder">
                            <span class="rate">86%</span>
                            <i class="fa-solid fa-star"></i>
                            <span class="reviews-count">(25 تقييما)</span>
                        </div>

                        <p class="author"> {{ $book->author->name }}</p>
                        <p class="publisher"> {{ $book->publisher->name }} </p>

                    </div>

                </div>
            </div>

            <div class="stats-grid grid mt-2">


                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>الحالة</h2>
                        <p> {{ $book->status == 'hidden' ? 'غير منشور' : 'منشور' }} </p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-eye "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>الكمّية</h2>
                        <p>{{ $book->quantity }}</p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-warehouse "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>مرحلة التنبيه</h2>
                        <p>{{ $book->stock_alert }}</p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-warning "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>عدد الطلبات</h2>
                        <p>256</p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-cart-arrow-down "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>عدد المفضلة</h2>
                        <p>140</p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-heart "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2> سعر التكلفة (د.ت)</h2>

                        <p>{{ $book->formattedCostPrice }}</p>


                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-sack-dollar "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>السعر (د.ت)</h2>

                        <p>{{ $book->formattedPrice }}</p>


                    </div>
                    <div class="icon-holder">
                        <i class="fa-solid fa-sack-dollar "></i>
                    </div>
                </div>
                <!-- End stat item -->
                <!-- Start stat item -->
                <div class="stat-item d-flex gap-0-5 f-wrap a-end j-between">
                    <div class="title-value-box">
                        <h2>تاريخ الإضافة</h2>
                        <p>{{ $book->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="icon-holder">
                        <i class="fa-regular fa-clock "></i>
                    </div>
                </div>
                <!-- End stat item -->


            </div>

            <div class="tabs-section mt-2 mb-2 holder pt-1 pb-1 pe-1 ps-1">

                <div class="tabs-holder">


                    <div class="tab" aria-expanded="true">
                        <div class="row grid admin-dashboard">
                            <div class="col review-stats-holder">
                                <div class="review-stats-header">
                                    <h2> تقييمات العملاء </h2>
                                    <div class="rate-holder">
                                        <span class="rate">86%</span>
                                        <i class="fa-solid fa-star"></i>
                                        <span class="reviews-count">(25 تقييما)</span>
                                    </div>
                                </div>
                                <div class="rate-stats-body">
                                    <ul>
                                        <!-- Start Li  -->
                                        <li>
                                            <div class="rate-list">
                                                <span>5</span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="50%" style="width: 50%;">
                                                        50%
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- End Li  -->
                                        <!-- Start Li  -->
                                        <li>
                                            <div class="rate-list">
                                                <span>4</span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="20%" style="width: 20%;">
                                                        20%
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- End Li  -->
                                        <!-- Start Li  -->
                                        <li>
                                            <div class="rate-list">
                                                <span>3</span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="20%" style="width: 20%;">
                                                        20%
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- End Li  -->
                                        <!-- Start Li  -->
                                        <li>
                                            <div class="rate-list">
                                                <span>2</span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="7%" style="width: 7%;">
                                                        7%
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- End Li  -->
                                        <!-- Start Li  -->
                                        <li>
                                            <div class="rate-list">
                                                <span>1</span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="3%" style="width: 3%;">
                                                        3%
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- End Li  -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col product-description">
                                <h2>وصف المنتج</h2>
                                <p>
                                    {{ $book->description }}
                                </p>
                            </div>
                        </div>
                        <div class="clients-reviews admin-dashboard">
                            <!-- Start Review -->
                            <div class="client-review">
                                <div class="client-review-header">
                                    <div class="reviewer-info">
                                        <div class="img-holder">
                                            <img src="../../assets/imgs/user.jpg" alt="">
                                        </div>
                                        <div>
                                            <p class="client-name">User Name</p>
                                            <p class="review-date">25 فيفري 2024</p>
                                        </div>
                                    </div>
                                    <div class="review">
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>

                                </div>
                                <div class="review-body">
                                    <p>
                                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من
                                        مولد
                                        النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى
                                        إضافة
                                        إلى
                                        زيادة عدد الحروف التى يولدها التطبيق.
                                    </p>
                                </div>
                            </div>
                            <!-- End Review -->
                            <!-- Start Review -->
                            <div class="client-review">
                                <div class="client-review-header">
                                    <div class="reviewer-info">
                                        <div class="img-holder">
                                            <img src="../../assets/imgs/user.jpg" alt="">
                                        </div>
                                        <div>
                                            <p class="client-name">اسم مستخدم</p>

                                            <p class="review-date">25 فيفري 2024</p>
                                        </div>

                                    </div>
                                    <div class="review">
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                    </div>
                                </div>
                                <div class="review-body">
                                    <p>
                                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من
                                        مولد
                                        النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى
                                        إضافة
                                        إلى
                                        زيادة عدد الحروف التى يولدها التطبيق.
                                    </p>
                                </div>
                            </div>
                            <!-- End Review -->
                            <!-- Start Review -->
                            <div class="client-review">
                                <div class="client-review-header">
                                    <div class="reviewer-info">
                                        <div class="img-holder">
                                            <img src="../../assets/imgs/user.jpg" alt="">
                                        </div>
                                        <div>
                                            <p class="client-name">User Name</p>
                                            <p class="review-date">25 فيفري 2024</p>
                                        </div>
                                    </div>
                                    <div class="review">
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star filled "></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <div class="review-body">
                                    <p>
                                        النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من
                                        مولد
                                        النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى
                                        إضافة
                                        إلى
                                        زيادة عدد الحروف التى يولدها التطبيق.
                                    </p>
                                </div>
                            </div>
                            <!-- End Review -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
