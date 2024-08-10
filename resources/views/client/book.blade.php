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

                            <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }} ">
                                {{ $book->isOutOfStock() ? 'غير متوفّر' : 'متوفّر' }}
                            </p>
                        </div>
                    </div>
                    <div class="img-holder">
                        <img loading="lazy" src="{{ asset('storage/' . $book->image) }}" alt="">
                    </div>
                    <div class="product-info">

                        <p class="category">{{ $book->category->name }}</p>
                        <h3 class="title"> {{ $book->name }} </h3>
                        <div class="rate-holder">
                            <span class="rate">{{ $book->rate }}</span>
                            <i class="fa-solid fa-star"></i>
                            <span class="reviews-count">({{ $book->formattedReviewsCount }})</span>
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
                                    @if ($book->reviews_count)
                                        <div class="review-stats-header">
                                            <h4> تقييمات العملاء </h4>
                                            <div class="rate-holder">
                                                <span class="rate">{{ $book->rate }}</span>
                                                <i class="fa-solid fa-star"></i>
                                                <span class="reviews-count">({{ $book->formattedReviewsCount }})</span>
                                            </div>
                                        </div>
                                        <div class="rate-stats-body">
                                            <ul>

                                                @for ($i = 5; $i >= 1; $i--)
                                                    <!-- Start Li  -->
                                                    <li>
                                                        <div class="rate-list">
                                                            <div class="count-holders">
                                                                <span>{{ $i }}</span> -
                                                                <span>({{ $starsCounts[$i]['percentage'] . '%' }})</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" data-value="50%"
                                                                    style="width: {{ $starsCounts[$i]['percentage'] }}%;">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- End Li  -->
                                                @endfor
                                            </ul>

                                        </div>
                                    @else
                                        <p>لا يوجد تقييمات لهذا الكتاب</p>
                                    @endif
                                </div>
                                <div class="col new-review-holder">
                                    <div class="new-review-header">
                                        <h4>أضف تقييمك</h4>
                                    </div>
                                    @auth
                                        @if (Auth::user()->hasBoughtThisBook($book->id) && !Auth::user()->hasReviewedThisBook($book->id))
                                            <form action="{{ route('client.reviews.store', $book) }}" method="post">
                                                @csrf
                                                <div class="stars-holder">
                                                    <!-- Start Star  -->
                                                    <div class="star-holder">
                                                        <input type="radio" name="stars" id="stars-5" value="5">
                                                        <label for="stars-5"> <i class="fa-solid fa-star"></i> 5 </label>
                                                    </div>
                                                    <!-- End Star  -->
                                                    <!-- Start Star  -->
                                                    <div class="star-holder">
                                                        <input type="radio" name="stars" id="stars-4" value="4">
                                                        <label for="stars-4"> <i class="fa-solid fa-star"></i> 4 </label>
                                                    </div>
                                                    <!-- End Star  -->
                                                    <!-- Start Star  -->
                                                    <div class="star-holder">
                                                        <input type="radio" name="stars" id="stars-3" value="3">
                                                        <label for="stars-3"> <i class="fa-solid fa-star"></i> 3 </label>
                                                    </div>
                                                    <!-- End Star  -->
                                                    <!-- Start Star  -->
                                                    <div class="star-holder">
                                                        <input type="radio" name="stars" id="stars-2" value="2">
                                                        <label for="stars-2"> <i class="fa-solid fa-star"></i> 2 </label>
                                                    </div>
                                                    <!-- End Star  -->
                                                    <!-- Start Star  -->
                                                    <div class="star-holder">
                                                        <input type="radio" name="stars" id="stars-1" value="1">
                                                        <label for="stars-1"> <i class="fa-solid fa-star"></i> 1 </label>
                                                    </div>
                                                    <!-- End Star  -->
                                                </div>
                                                <textarea name="comment" id="review-message" cols="30" rows="10" placeholder="أضف تعليقك هنا"></textarea>
                                                <button id="submit-review">إرسال</button>
                                            </form>
                                        @else
                                            @if (Auth::user()->hasReviewedThisBook($book->id))
                                                <p>لقد قمت بتقييم هذا الكتاب من قبل</p>
                                            @else
                                                <p>التقييم متاح فقط للعملاء الذين قاموا بشراء هذا الكتاب من قبل</p>
                                            @endif
                                        @endif
                                    @endauth
                                    @guest
                                        <p>لإضافة تقييم, الرجاء تسجيل الدخول</p>
                                    @endguest
                                </div>
                            </div>
                            <div class="clients-reviews">
                                @foreach ($book->reviews as $review)
                                    <!-- Start Review -->
                                    <div class="client-review">
                                        <div class="client-review-header">
                                            <div class="reviewer-info">
                                                <div class="img-holder">
                                                    <img src="{{ asset('storage/' . $review->user->photo) }}"
                                                        alt="">
                                                </div>
                                                <div>
                                                    <p class="client-name"> {{ $review->user->fullName }}</p>
                                                    <p class="review-date">
                                                        {{ $review->created_at->format('Y - m - d : H:i') }}</p>
                                                </div>
                                            </div>
                                            <div class="review">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa-solid fa-star {{ $i <= $review->stars ? 'filled' : '' }}"></i>
                                                @endfor
                                            </div>

                                        </div>
                                        <div class="review-body">
                                            @if ($review->comment != null)
                                                <p>{{ $review->comment }}</p>
                                            @endif

                                        </div>
                                    </div>
                                    <!-- End Review -->
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <!-- End Tab -->
                </div>
            </div>
        </div>
        </div>

    </main>
@endsection
