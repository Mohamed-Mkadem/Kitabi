@extends('layouts.admin')

@push('title')
    <title>لوحة التحكّم - التقييمات</title>
@endpush

@push('script')
@endpush


@section('content')
    <div id="admin-reviews">
        <section class="content" id="content">


            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-between " id="starter-header">
                <div class="greeting-holder">
                    <h1>التقييمات</h1>
                    <x-breadcrumb class="dashboard" prevUrl="{{ route('admin.home') }}" prevValue="الرئيسية"
                        currUrl="{{ route('admin.reviews.index') }}" currValue="التقييمات" />
                </div>
            </div>
            <!-- End Starter Header -->


            <div class="holder mt-1 mb-1 pt-2 pb-2 ps-1 pe-1">
                <div class="filters-form">
                    <div class="filters-header">
                        <h2 class="mb-1 form-title">بحث متقدّم</h2>
                    </div>
                    <div class="filters-body">
                        <form action="{{ route('admin.reviews.filter') }}" method="get" class="form-grid">
                            <div class="row mb-1">

                                <div class="form-control">
                                    <label for="book_name">اسم الكتاب</label>
                                    <input class="form-element" type="text" name="search" id="book_name"
                                        placeholder="اسم الكتاب" value="{{ request()->search }}">
                                </div>
                                <div class="form-control">
                                    <label for="sort-options">الترتيب</label>
                                    <div class="select-box">
                                        <select class="form-element" id="sort-options" name="sort">
                                            <option {{ request()->sort == 'newest' ? 'selected' : '' }} value="newest">
                                                الأحدث</option>
                                            <option {{ request()->sort == 'oldest' ? 'selected' : '' }} value="oldest">
                                                الأقدم</option>
                                            <option {{ request()->sort == 'highest_rate' ? 'selected' : '' }}
                                                value="highest_rate">الأعلى تقييما</option>
                                            <option {{ request()->sort == 'lowest_rate' ? 'selected' : '' }}
                                                value="lowest_rate">الأقلّ تقييما</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="form-control">
                                    <label>عدد النجوم</label>
                                    <div class="statuses-holder sm">
                                        <div class="status form-element">
                                            <label for="star-1">1</label>
                                            <input {{ in_array('1', (array) request()->stars) ? 'checked' : '' }}
                                                type="checkbox" id="star-1" name="stars[]" value="1">
                                        </div>
                                        <div class="status form-element">
                                            <label for="star-2">2</label>
                                            <input {{ in_array('2', (array) request()->stars) ? 'checked' : '' }}
                                                type="checkbox" id="star-2" name="stars[]" value="2">
                                        </div>
                                        <div class="status form-element">
                                            <label for="star-3">3</label>
                                            <input {{ in_array('3', (array) request()->stars) ? 'checked' : '' }}
                                                type="checkbox" id="star-3" name="stars[]" value="3">
                                        </div>
                                        <div class="status form-element">
                                            <label for="star-4">4</label>
                                            <input {{ in_array('4', (array) request()->stars) ? 'checked' : '' }}
                                                type="checkbox" id="star-4" name="stars[]" value="4">
                                        </div>
                                        <div class="status form-element">
                                            <label for="star-5">5</label>
                                            <input {{ in_array('5', (array) request()->stars) ? 'checked' : '' }}
                                                type="checkbox" id="star-5" name="stars[]" value="5">
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 ">
                                <div class="form-control">
                                    <label>تاريخ التقييم</label>
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


                            <div class="d-flex a-center gap-1 f-wrap mt-2">
                                <button class="submitBtn" type="submit">بحث</button>
                                <button class="resetBtn" type="reset">حذف</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            @if ($reviews->count() > 0)
                <div class="grid reviews-grid">
                    @foreach ($reviews as $review)
                        <!-- Start Review -->
                        <div class="card review-card">
                            <button class="modal-controller"></button>
                            <div class="modal-holder">
                                <div class="modal review-details">
                                    <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                                        <h2>تفاصيل التقييم</h2>
                                        <button class="modal-closer">
                                            <i class="fa-solid fa-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h3>الكتاب</h3>
                                        <div class="info-wrapper book-holder">
                                            <img src="{{ $review->book->image }}" alt="">
                                            <div>
                                                <a
                                                    href="{{ route('admin.books.show', $review->book) }}">{{ $review->book->name }}</a>
                                                <p> {{ $review->book->author->name }}</p>
                                                <p> {{ $review->book->publisher->name }}</p>
                                                <div class="rate-holder">
                                                    <span class="rate">{{ $review->book->rate }}</span>
                                                    <i class="fa-solid fa-star"></i>
                                                    <span
                                                        class="reviews-count">({{ $review->book->formattedReviewsCount }})</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h3>العميل</h3>
                                        <div class="info-wrapper client-holder">
                                            <img src="{{ asset('storage/' . $review->user->photo) }}" alt="">
                                            <div>
                                                <a href="{{ route('admin.clients.show', $review->user) }}">
                                                    {{ $review->user->fullName }}</a>
                                                <p>
                                                    {{ $review->user->formattedReviewsCount }}
                                                </p>
                                            </div>
                                        </div>
                                        <h3>التقييم</h3>
                                        <div class="d-flex a-center f-wrap stars-holder">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa-solid fa-star {{ $i <= $review->stars ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="comment ">
                                            @if ($review->comment)
                                                {{ $review->comment }}
                                            @else
                                                لم يترك العميل أي تعليق
                                            @endif
                                        </p>
                                        <div class="d-flex j-end mt-1">

                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="deleteBtn">حذف التقييم</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header d-flex j-between f-wrap gap-1 a-center">
                                <p class="date">
                                    <i class="fa-regular fa-clock"></i>
                                    <span dir="ltr">
                                        {{ $review->created_at->format('Y - m - d : H:i') }}
                                    </span>
                                </p>
                                <div class="d-flex a-center j-between f-wrap stars-holder">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->stars ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="book-holder ">
                                    <img src="{{ $review->book->image }}" alt="">
                                    <h2>{{ $review->book->name }}</h2>
                                </div>
                                <p>
                                    {{ $review->comment }}
                                </p>
                            </div>
                        </div>
                        <!-- End Review -->
                    @endforeach
                </div>
                <!-- Start Pagination -->
                {!! $reviews->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            @else
                <div class="not-found-wrapper  show">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>لم يتمّ العثور على أيّ نتائج</p>
                </div>
            @endif

        </section>
    </div>
@endsection
