@if ($books->count() > 0)
    <div class="products-grid grid ">
        @foreach ($books as $book)
            <!-- Start Product -->
            <div class="product">
                <div class="product-header">
                    <div class="top-bar-info">
                        <p class="rate"> {{ $book->rate }} <i class="fa-solid fa-star filled"></i></p>
                        <p class="status {{ $book->isOutOfStock() ? 'not-available' : '' }}">
                            {{ $book->isOutOfStock() ? 'غير متوفر' : 'متوفّر' }}
                        </p>
                    </div>
                </div>


                <div class="img-holder">
                    <img loading="lazy" src="{{ asset('storage/' . $book->image) }}" alt="">
                </div>
                <div class="product-info">

                    <p class="category">{{ $book->category->name }}</p>
                    <h3 class="title"><a href="{{ route('client.shop.book', $book) }}"> {{ $book->name }} </a></h3>
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
                        <input class="quantity-input" type="number" value="1" lang="en" min="1">
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
