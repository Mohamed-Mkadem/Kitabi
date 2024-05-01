@extends('layouts.client')

@push('meta')
    <title>كتابي - {{ $book->name }}</title>
@endpush
@push('script')
    @vite('resources/js/productPage.js')
@endpush
@section('content')
    <main id="book">
        <div class="container">
            <h1 class="page-title">تفاصيل الكتاب</h1>

            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية"
                currUrl="{{ route('client.shop.book', $book) }}" currValue="تفاصيل الكتاب" />

        </div>

        <div class="container">
            <div class="product-holder products-container">
                <div class="product no-shadow">
                    <div class="product-header">

                        <div class="top-bar-info">
                            <button data-product-id="{{ $book->id }}"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }} ">
                                {{ $book->isOutOfStock() ? 'غير متوفّر' : 'متوفّر' }}
                            </p>
                        </div>
                    </div>
                    <div class="img-holder">
                        <img loading="lazy" src="{{ $book->image }}" alt="">
                    </div>
                    <div class="product-info">

                        <p class="category">{{ $book->category->name }}</p>
                        <h3 class="title"> {{ $book->name }} </h3>
                        <div class="rate-holder">
                            <span class="rate">86%</span>
                            <i class="fa-solid fa-star"></i>
                            <span class="reviews-count">(25 تقييما)</span>
                        </div>
                        <p class="price"><span> {{ $book->formattedPrice }} </span> د.ت</p>
                        <p class="author">{{ $book->author->name }}</p>
                        <p class="publisher"> {{ $book->publisher->name }} </p>
                    </div>
                    <div class="add-to-cart-holder">
                        <button class="add-to-cart-btn" data-product-id="{{ $book->id }}">
                            <span>أضف إلى السلّة</span>
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                        <div class="quantity-holder">
                            <button class="minus-btn">-</button>
                            <input class="quantity-input" type="number" value="1" lang="en" min="1">
                            <button class="plus-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="container">
                <div class="tabs-section">
                    <div class="tabs-filters">
                        <ul>
                            <li>
                                <h3>وصف المنتج</h3>
                                <button data-index="1" aria-checked="true"></button>
                            </li>
                            <li>
                                <h3>التقييم</h3>
                                <button data-index="2"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="tabs-holder">
                        <!-- Start Tab -->
                        <div class="tab" data-tab="1" aria-expanded="true">
                            <p>
                                {{ $book->description }}
                            </p>
                        </div>
                        <!-- End Tab -->
                        <!-- Start Tab -->
                        <div class="tab" data-tab="2" aria-expanded="false">
                            <div class="row grid">
                                <div class="col review-stats-holder">
                                    <div class="review-stats-header">
                                        <h4> تقييمات العملاء </h4>
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
                                <div class="col new-review-holder">
                                    <div class="new-review-header">
                                        <h4>أضف تقييمك</h4>
                                    </div>
                                    <div class="stars-holder">
                                        <!-- Start Star  -->
                                        <div class="star-holder">
                                            <input type="radio" name="stars" id="stars-5">
                                            <label for="stars-5"> <i class="fa-solid fa-star"></i> 5 </label>
                                        </div>
                                        <!-- End Star  -->
                                        <!-- Start Star  -->
                                        <div class="star-holder">
                                            <input type="radio" name="stars" id="stars-4">
                                            <label for="stars-4"> <i class="fa-solid fa-star"></i> 4 </label>
                                        </div>
                                        <!-- End Star  -->
                                        <!-- Start Star  -->
                                        <div class="star-holder">
                                            <input type="radio" name="stars" id="stars-3">
                                            <label for="stars-3"> <i class="fa-solid fa-star"></i> 3 </label>
                                        </div>
                                        <!-- End Star  -->
                                        <!-- Start Star  -->
                                        <div class="star-holder">
                                            <input type="radio" name="stars" id="stars-2">
                                            <label for="stars-2"> <i class="fa-solid fa-star"></i> 2 </label>
                                        </div>
                                        <!-- End Star  -->
                                        <!-- Start Star  -->
                                        <div class="star-holder">
                                            <input type="radio" name="stars" id="stars-1">
                                            <label for="stars-1"> <i class="fa-solid fa-star"></i> 1 </label>
                                        </div>
                                        <!-- End Star  -->
                                    </div>
                                    <textarea name="" id="review-message" cols="30" rows="10" placeholder="أضف تعليقك هنا"></textarea>
                                    <button id="submit-review">إرسال</button>
                                </div>
                            </div>
                            <div class="clients-reviews">
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
                                            النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة
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
                                            النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة
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
                                            النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة
                                            إلى
                                            زيادة عدد الحروف التى يولدها التطبيق.
                                        </p>
                                    </div>
                                </div>
                                <!-- End Review -->
                            </div>
                        </div>
                        <!-- End Tab -->
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
