<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/imgs/favicon.png') }}">
    @stack('title')
    @stack('meta')
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Stylesheets -->

    @vite(['resources/sass/main.scss', 'resources/sass/utilities.scss', 'resources/js/main.js', 'resources/js/cart-actions.js'])
    @stack('script')
</head>

<body>

    <div id="overlay"></div>
    <div id="fixed-menu">

        <ul>
            <li>

                <a href="{{ route('client.home') }}" current-page="{{ request()->is('/') ? 'true' : 'false' }}">
                    <i class="fa-solid fa-house"></i>
                    الرئيسية
                </a>
            </li>
            <li>

                <a href="{{ route('client.shop') }}" current-page="{{ request()->is('shop*') ? 'true' : '' }}">
                    <i class="fa-solid fa-shop"></i>
                    المتجر
                </a>
            </li>
            <li>
                <a href="wishlist.html" current-page="{{ request()->is('wishlist*') ? 'true' : '' }}">
                    <i class="fa-regular fa-heart"></i>
                    المفضلة
                </a>
            </li>
            <li>
                <a href="cart.html" current-page="{{ request()->is('cart*') ? 'true' : '' }}">
                    <span id="fixed-menu-count">9</span>
                    <i class="fa-solid fa-bag-shopping"></i>
                    السلّة
                </a>
            </li>
        </ul>
    </div>
    <div class="top-bar-menu">
        @auth
            <p>Authenitcated</p>
        @endauth
        @guest
            <p>Guest</p>
        @endguest
    </div>
    <div class="container">
        <div id="main-header">
            <div class="search-holder">
                <button class="icon-btn modal-holder-toggler"><i class="fa-solid fa-magnifying-glass"></i></button>
                <div class="modal-holder ">
                    <form action="" method="get" id="search-form">
                        <input type="search" class="full-screen" placeholder="بحث عن كتاب">
                        <button type="submit">بحث</button>
                    </form>
                </div>
            </div>
            <a href="{{ route('client.home') }}" class="logo">كتابي</a>
            <div class="nav-holder">
                <button id="navigation-menu-toggle" aria-expanded="false" aria-controls="#navigation-menu"
                    class="icon-btn"><i class="fa-solid fa-bars"></i></button>
                <nav id="navigation-menu" aria-expanded="false">
                    <ul>
                        <li><a current-page="{{ request()->is('/') ? 'true' : '' }}"
                                href="{{ route('client.home') }}">الرئيسية</a>
                        </li>
                        <li><a current-page="{{ request()->is('shop*') ? 'true' : '' }}"
                                href="{{ route('client.shop') }}">المتجر</a></li>
                        <li><a current-page="{{ request()->is('order*') ? 'true' : '' }}" href="/orders">الطلبات</a>
                        </li>
                        <li><a current-page="{{ request()->is('about') ? 'true' : '' }}"
                                href="{{ route('client.about') }}">
                                من نحن
                            </a>
                        </li>
                        <li><a current-page="{{ request()->is('contact*') ? 'true' : '' }}" href="/contact">اتصل
                                بنا</a>
                        </li>

                    </ul>
                </nav>
            </div>
            <div class="user-actions-holder ">
                <div class="actions-holder user-action-item dropdown-holder">
                    <button class="icon-btn dropdown-btn">
                        <i class="fa-regular fa-circle-user"></i>
                    </button>
                    <ul class="dropdown">
                        @guest
                            <li><a href="{{ route('register') }}">إنشاء حساب</a></li>
                            <li><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                        @endguest
                        @auth


                            <li><a
                                    href="
                                    {{ route(Auth::user()->isAdmin() ? 'admin.profile.index' : 'client.profile.index') }}
                                    ">الملف
                                    الشخصي</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit">خروج</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
                <a href="notifications.html" class="user-action-item notifications-item icon-btn">
                    <i class="fa-regular fa-bell"></i>
                </a>

                <a href="wishlist.html" class="user-action-item wishlist-item icon-btn">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <div class="dropdown-holder cart-holder">

                    <a href="cart.html" class="user-action-item icon-btn">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span id="cart-count">0</span>
                    </a>
                    <div class="dropdown " id="cart-content-dropdown">
                        <p class="cart-empty">السلة فارغة</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @yield('content')
    <footer>
        <div class="container">
            <div class="footer-wrapper">
                <div class="footer-grid grid">
                    <div class="col logo-info-holder">
                        <a href="{{ route('client.home') }}" class="logo">كتابي</a>
                        <p class="address">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>
                                25 شارع معين في تونس العاصمة
                            </span>
                        </p>
                        <p class="phone">
                            <i class="fa-solid fa-phone"></i>
                            <span dir="ltr">
                                +216 00 000 000
                            </span>
                        </p>
                        <p class="phone">
                            <i class="fa-solid fa-envelope"></i>
                            <span dir="ltr">

                                user@email.com
                            </span>
                        </p>
                    </div>
                    <div class="col useful-links">
                        <h2>روابط مفيدة</h2>
                        <ul>
                            <li><a href="{{ route('client.faqs') }}">الأسئلة الشائعة</a></li>
                            <li><a href="{{ route('client.terms') }}">سياسة الاستخدام</a></li>
                            <li><a href="{{ route('client.privacy') }}">سياسة الخصوصية</a></li>
                        </ul>
                    </div>
                    <div class="col pages">
                        <h2>الصفحات</h2>
                        <ul>
                            <li><a href="{{ route('client.home') }}">الرئيسية</a></li>
                            <li><a href="{{ route('client.shop') }}">المتجر</a></li>
                            <li><a href="{{ route('client.about') }} ">من نحن</a></li>
                            <li><a href="{{ route('client.contact') }}">اتصل بنا</a></li>

                        </ul>
                    </div>

                    <div class="col social-media">
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-telegram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-square-x-twitter"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col copyrights">
                        <p>جميع الحقوق محفوظة &copy;</p>
                    </div>
                </div>

            </div>
        </div>
    </footer>



    <audio id="add-to-cart-sound-effect" src="{{ @asset('assets/sounds/add.wav') }}"></audio>
    <audio id="remove-from-cart-sound-effect" src=" {{ @asset('assets/sounds/remove.mp3') }}"></audio>

</body>

</html>
