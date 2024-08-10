@extends('layouts.client')

@push('title')
    <title>كتابي - المتجر</title>
@endpush
@push('script')
    @vite('resources/js/shop.js')
@endpush
@section('content')
    <main id="shop">
        <div class="container">

            <h1 class="page-title">المتجر</h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.shop') }}"
                currValue="المتجر" />


            <section class="shop-grid grid">
                <aside id="shop-aside">
                    <button id="close-aside">
                        <i class="fa-solid fa-close"></i>
                    </button>
                    <h2>بحث متقدم</h2>

                    <div class="filters">
                        <div class="filter-column">
                            <div class="filter-column-header">
                                <h3>اسم الكتاب</h3>

                            </div>
                            <div class="filter-column-wrapper">
                                <div class="input-holder">
                                    <input value="{{ request()->search }}" type="search" placeholder="اسم اكتاب"
                                        name="search" id="bookName">
                                </div>
                            </div>
                        </div>

                        <div class="filter-column">
                            <div class="filter-column-header">
                                <h3>التصنيف</h3>

                            </div>
                            <div class="filter-column-wrapper">
                                <div class="input-holder">
                                    <input type="search" name="" placeholder="اسم التصنيف" id="categories-input">
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
                                <h3>الكاتب</h3>

                            </div>
                            <div class="filter-column-wrapper">
                                <div class="input-holder">
                                    <input type="search" placeholder="اسم الكاتب" name="" id="authors-input">
                                </div>
                                <div class="choices-wrapper authors-choices">


                                    @foreach ($authors as $author)
                                        <div class="choice">
                                            <input {{ in_array($author->id, (array) request()->authors) ? 'checked' : '' }}
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
                                <h3>
                                    السعر
                                    <span>(د.ت)</span>
                                </h3>

                            </div>
                            <div class="filter-column-wrapper">
                                <div class="price-range-holder">
                                    <label for="minPrice">من</label>
                                    <input type="number" name="min_price" value="{{ request()->min_price }}"
                                        step="0.01" id="minPrice" placeholder="مثال : 10">
                                    <label for="maxPrice">إلى</label>
                                    <input type="number" value="{{ request()->max_price }}" step="0.01"
                                        name="max_price" id="maxPrice" placeholder="مثال : 1500">
                                </div>
                            </div>
                        </div>

                        <div class="filter-column">
                            <div class="filter-column-header">
                                <h3>دار النشر</h3>

                            </div>
                            <div class="filter-column-wrapper">
                                <div class="input-holder">
                                    <input type="search" name="" placeholder="اسم دار النشر" id="publishers-input">
                                </div>
                                <div class="choices-wrapper publishers-choices">

                                    @foreach ($publishers as $publisher)
                                        <div class="choice">
                                            <input
                                                {{ in_array($publisher->id, (array) request()->publishers) ? 'checked' : '' }}
                                                type="checkbox" name="publishers[]" value="{{ $publisher->id }}"
                                                id="publisher-{{ $publisher->id }}">
                                            <label for="publisher-{{ $publisher->id }}">{{ $publisher->name }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="main-area">
                    <div class="actions-holder">
                        <button id="sidebar-toggle"> بحث متقدم <i class="fa-solid fa-filter"></i></button>
                        <div class="select-box">
                            <select id="sort-options">
                                <option {{ request()->sort == 'newest' ? 'selected' : '' }} value="newest">الأحدث</option>
                                <option {{ request()->sort == 'oldest' ? 'selected' : '' }} value="oldest">الأقدم</option>
                                <option {{ request()->sort == 'highest_price' ? 'selected' : '' }} value="highest_price">
                                    الأغلى</option>
                                <option {{ request()->sort == 'lowest_price' ? 'selected' : '' }} value="lowest_price">
                                    الأرخص</option>
                            </select>
                        </div>


                        <div class="grid-list-togglers">
                            <button id="list-vue">
                                <i class="fa-solid fa-list"></i>
                            </button>
                            <button id="grid-vue" aria-selected="true">
                                <i class="fa-solid fa-grip"></i>
                            </button>
                        </div>
                    </div>
                    <div id="results-container" class="products-container">
                        @if ($books->count() > 0)
                            <div class="products-grid grid ">
                                @foreach ($books as $book)
                                    <!-- Start Product -->
                                    <div class="product">
                                        <div class="product-header">
                                            <div class="top-bar-info">
                                                <p class="rate"> {{ $book->rate }} <i
                                                        class="fa-solid fa-star filled"></i></p>
                                                <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }}">
                                                    {{ $book->isOutOfStock() ? 'غير متوفر' : 'متوفّر' }}
                                                </p>
                                            </div>
                                        </div>


                                        <div class="img-holder">
                                            <img loading="lazy" src="{{ asset('storage/' . $book->image) }}"
                                                alt="">
                                        </div>
                                        <div class="product-info">

                                            <p class="category">{{ $book->category->name }}</p>
                                            <h3 class="title"><a href="{{ route('client.shop.book', $book) }}">
                                                    {{ $book->name }} </a></h3>
                                            <p class="price"><span> {{ $book->formattedPrice }} </span> د.ت</p>
                                            <p class="author">{{ $book->author->name }}</p>
                                            <p class="publisher">{{ $book->publisher->name }}</p>
                                        </div>
                                        <div class="add-to-cart-holder">
                                            <button class="add-to-cart-btn" data-product-id="{{ $book->id }}">
                                                <span>أضف إلى السلّة</span>
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </button>
                                            <div class="quantity-holder">
                                                <button class="minus-btn">-</button>
                                                <input class="quantity-input" type="number" value="1"
                                                    lang="en" min="1">
                                                <button class="plus-btn">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product -->
                                @endforeach
                            </div>
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
                </div>
            </section>


        </div>

    </main>
@endsection
