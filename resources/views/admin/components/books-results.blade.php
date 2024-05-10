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
                            <span>86%</span>
                            <i class="fa-solid fa-star"></i>
                        </p>
                        <p class="quantity">
                            <span>{{ $book->quantity }}</span>
                            <i class="fa-solid fa-warehouse"></i>
                        </p>
                    </div>
                </div>
                <div class="img-holder">
                    <img loading="lazy" src="{{ $book->image }}" alt="">
                    {{-- <img loading="lazy" src="{{ asset('storage/' . $book->image) }}" alt=""> --}}
                </div>
                <div class="product-info">

                    <p class="category">{{ $book->category->name }}</p>
                    <h3 class="title"><a href="{{ route('admin.books.edit', $book) }}">
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
