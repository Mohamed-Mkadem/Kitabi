@extends('layouts.client')
@push('title')
    <title>كتابي - الرئيسية</title>
@endpush
@section('content')
    <main id="home">
        <div class="showcase">
            <h1>كتابي - بوابتك إلى عالم الكتب: اكتشف، اقرأ، ارتقِ</h1>
            <p>
                نوفر مجموعة متنوعة من الكتب العلمية والروايات وكتب الأطفال بأجود الخامات وأفضل الأسعار
            </p>
            <a href="shop.html" class="cta centered outlined">تصفّح الكتب</a>
        </div>
        <section class="featured-products">
            <div class="container">
                <h2 class="section-title">منتجاتنا</h2>
                <div class="products-grid grid">
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">
                            <div class="top-bar-info">
                                <button data-product-id="1"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status not-available">غير متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">

                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="1">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en" min="1">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="2"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="2">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="3"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="3">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="4"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="4">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="5"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="5">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="6"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="6">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="7"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="7">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="product-header">

                            <div class="top-bar-info">
                                <button data-product-id="8"> <i class="fa-regular fa-heart"></i> </button>
                                <p class="status available">متوفر</p>
                            </div>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="8">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                </div>
                <a href="shop.html" class="cta centered ">تصفّح الكلّ</a>
            </div>
        </section>
        <section class="newest-products">
            <div class="container">
                <h2 class="section-title">وصل حديثا</h2>
                <div class="products-grid grid">
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="1"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status not-available">غير متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">

                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="1">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en" min="1">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="2"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="2">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="3"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="3">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="4"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="4">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="5"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="5">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="6"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="6">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="7"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="7">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                    <!-- Start Product -->
                    <div class="product">
                        <div class="top-bar-info">
                            <button data-product-id="8"> <i class="fa-regular fa-heart"></i> </button>
                            <p class="status available">متوفر</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="https://picsum.photos/200/300" alt="">
                        </div>
                        <div class="product-info">
                            <p class="category">أدب</p>
                            <h3 class="title"><a href="book.html"> تاريخ الأدب العربي الحديث </a></h3>
                            <p class="price"><span> 19.900 </span> د.ت</p>
                            <p class="author">إسم الكاتب</p>
                            <p class="publisher">دار السلام للنشر</p>
                        </div>
                        <div class="add-to-cart-holder">
                            <button class="add-to-cart-btn" data-product-id="8">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" value="1" lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product -->
                </div>
                <a href="shop.html" class="cta centered ">تصفّح الكلّ</a>
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
