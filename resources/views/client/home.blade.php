@extends('layouts.client')
@push('title')
    <title>كتابي - الرئيسية</title>
@endpush
@section('content')
    <main id="home">
        <div class="showcase">
            <h1>كتابي - بوّابتك إلى عالم الكتب: اكتشف، اقرأ، ارتقِ</h1>
            <p>
                نوفّر مجموعة متنوّعة من الكتب العلمية والروايات وكتب الأطفال بأجود الخامات وأفضل الأسعار
            </p>
            <a href="{{ route('client.shop') }}" class="cta centered outlined">تصفّح الكتب</a>
        </div>
        <section class="featured-products">
            <div class="container">
                <h2 class="section-title">الأكثر مبيعََا</h2>
                <div class="products-grid grid products-container">
                    @foreach ($bestSellingBooks as $book)
                        <!-- Start Product -->
                        <div class="product">
                            <div class="product-header">
                                <div class="top-bar-info">
                                    <p class="rate"> {{ $book->rate }} <i class="fa-solid fa-star filled"></i></p>
                                    <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }}">
                                        {{ $book->isOutOfStock() ? 'غير متوفّر' : 'متوفّر' }}
                                    </p>
                                </div>
                            </div>
                            <div class="img-holder">
                                <img loading="lazy" src="{{ $book->image }}" alt="">
                            </div>
                            <div class="product-info">

                                <p class="category">{{ $book->category->name }}</p>
                                <h3 class="title"><a href="{{ route('client.shop.book', $book) }}"> {{ $book->name }}
                                    </a>
                                </h3>
                                <p class="price"><span> {{ $book->formattedPrice }} </span> د.ت</p>
                                <p class="author">{{ $book->author->name }}</p>
                                <p class="publisher">{{ $book->publisher->name }}</p>
                            </div>
                            <div class="add-to-cart-holder">
                                <button class="add-to-cart-btn" data-product-id="{{ $book->id }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>
                                <div class="quantity-holder">
                                    <button class="minus-btn">-</button>
                                    <input class="quantity-input" type="number" value="1" lang="en"
                                        min="1">
                                    <button class="plus-btn">+</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Product -->
                    @endforeach
                </div>
                <a href="{{ route('client.shop') }}" class="cta centered ">تصفّح الكلّ</a>
            </div>
        </section>
        <section class="newest-products">
            <div class="container">
                <h2 class="section-title">وصل حديثا</h2>
                <div class="products-grid grid products-container">
                    @foreach ($latestBooks as $book)
                        <!-- Start Product -->
                        <div class="product">
                            <div class="product-header">
                                <div class="top-bar-info">
                                    <p class="rate"> {{ $book->rate }} <i class="fa-solid fa-star filled"></i></p>
                                    <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }}">
                                        {{ $book->isOutOfStock() ? 'غير متوفّر' : 'متوفّر' }}
                                    </p>
                                </div>
                            </div>
                            <div class="img-holder">
                                <img loading="lazy" src="{{ $book->image }}" alt="">
                            </div>
                            <div class="product-info">

                                <p class="category">{{ $book->category->name }}</p>
                                <h3 class="title"><a href="{{ route('client.shop.book', $book) }}"> {{ $book->name }}
                                    </a></h3>
                                <p class="price"><span> {{ $book->formattedPrice }} </span> د.ت</p>
                                <p class="author">{{ $book->author->name }}</p>
                                <p class="publisher">{{ $book->publisher->name }}</p>
                            </div>
                            <div class="add-to-cart-holder">
                                <button class="add-to-cart-btn" data-product-id="{{ $book->id }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>
                                <div class="quantity-holder">
                                    <button class="minus-btn">-</button>
                                    <input class="quantity-input" type="number" value="1" lang="en"
                                        min="1">
                                    <button class="plus-btn">+</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Product -->
                    @endforeach

                </div>
                <a href="{{ route('client.shop') }}" class="cta centered ">تصفّح الكلّ</a>
            </div>
        </section>
        <section class="why-us">
            <h2 class="section-title">لماذا كتابي ؟</h2>
            <div class="container">
                <div class="why-us-grid grid">
                    <div class="grid-item">
                        <i class="fa-regular fa-square-check"></i>
                        <p>طبعات فاخرة ومميزة</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-book"></i>
                        <p>إصدارات حديثة ومتنوعة</p>
                    </div>
                    <div class="grid-item">
                        <i class="fa-solid fa-truck-fast fa-flip-horizontal"></i>
                        <p>توصيل لكامل الجمهورية</p>
                    </div>
                </div>
            </div>

        </section>

    </main>
@endsection
