<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/imgs/favicon.png') }}">
    @stack('title')
    @stack('meta')
    @stack('script')
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Stylesheets -->
    @vite(['resources/sass/main.scss', 'resources/sass/utilities.scss', 'resources/js/dashboard.js'])



</head>


<body class="gray">

    <div id="overlay" class="overlay"></div>
    <div class="main-wrapper">
        <aside id="aside" aria-current="expanded">
            <a href="{{ route('admin.home') }}" class="logo d-block light visible">
                <i class="fa-solid fa-book"></i>
                <span>كتابي</span>
            </a>
            <button id="aside-toggle">
                <i class="fa-regular fa-circle-xmark"></i>
            </button>



            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link active">
                        <i class="fa-solid fa-house"></i><span>الرئيسية </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-solid fa-list"></i><span>التصنيفات </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-regular fa-keyboard"></i>
                        <span>المؤلّفون </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-solid fa-book-atlas"></i>
                        <span> الناشرون </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu" class="nav-link collapsed"> <i
                            class="fa-solid fa-book"></i> <span>الكتب</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item">
                            <a href="">إضافة كتاب</a>
                        </li>
                        <li class="nav-item"><a href="">عرض الكتب</a></li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                        <span> الطلبات </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-regular fa-bell"></i><span> الإشعارات </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-solid fa-users"></i>
                        <span> العملاء </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="fa-solid fa-warehouse"></i>
                        <span> المخزن </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link notifiable">
                        <i class="fa-regular fa-star"></i>
                        <span> التقييمات </span>
                    </a>
                </li>








            </ul>
        </aside>
        <main id="main-content">
            <!-- Header -->
            <header id="header" class="d-flex j-between a-center">
                <!-- Layout Toggler -->
                <button id="layout-toggle" class="icon-btn "><i class="fa-solid fa-bars"></i></button>


                <div class="dropdowns-holder d-flex  a-center">

                    <div class="dropdown-holder">
                        <button id="notifications-handler" data-count="99" class="top-bar-btn dropdown-toggle"
                            aria-pressed="false">
                            <i class="fa-regular fa-bell"></i>
                        </button>
                        <div class="dropdown-menu notifications-dropdown ">
                            <h4>الإشعارات</h4>
                            <ul class="notifications-wrapper">
                                <!-- Start Notification -->
                                <li class="notification unread">
                                    <img src="../../assets/imgs/user.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href="" class="unread">
                                                هذا النص هو مثال لنص يمكن استبداله في نفس المساحة.
                                            </a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-regular fa-clock"></i> منذ 4 ساعات
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification unread">
                                    <img src="../../assets/imgs/user.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href="" class="unread">
                                                هذا النص هو مثال لنص يمكن استبداله في نفس المساحة.
                                            </a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-regular fa-clock"></i> منذ 4 ساعات
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification ">
                                    <img src="../../assets/imgs/user.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href="" class="unread">
                                                هذا النص هو مثال لنص يمكن استبداله في نفس المساحة.
                                            </a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-regular fa-clock"></i> منذ 4 ساعات
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification unread">
                                    <img src="../../assets/imgs/user.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href="" class="unread">
                                                هذا النص هو مثال لنص يمكن استبداله في نفس المساحة.
                                            </a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-regular fa-clock"></i> منذ 4 ساعات
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->


                            </ul>
                            <a href="notifications.html" class="see-all d-block t-center">See All</a>
                        </div>
                    </div>

                    <div class="dropdown-holder">
                        <button id="profile-handler" class=" d-flex  a-center dropdown-toggle" aria-pressed="false">
                            <img id="header-avatar" src="{{ asset('storage/' . request()->user()->photo) }}"
                                alt="">
                            <span>كتابي</span>
                        </button>
                        <ul class="dropdown-menu profile-dropdown  ">
                            <li><a href="{{ route('admin.profile.index') }}"> حسابي</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit"> خروج</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>

            </header>

            <div class="container fluid">
                @yield('content')
            </div>
        </main>
    </div>



    {{-- @include('components.errors') --}}
    @include('components.success-alert')
</body>

</html>
