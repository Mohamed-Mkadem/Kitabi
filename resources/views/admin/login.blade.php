<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كتابي - تسجيل الدخول</title>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Stylesheets -->
    @vite(['resources/js/validate-login.js', 'resources/sass/main.scss', 'resources/sass/utilities.scss'])
</head>

<body style="height: 100vh;">

    <main id="authentication" class="admin-login d-flex j-center a-center " style="height: 100%;">
        <div class="container">
            <div class="auth-wrapper login">
                <h1 class=" t-center">تسجيل الدخول</h1>
                <form action="{{ route('login') }}" method="post" id="login-form" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-control">
                            <label for="email">البريد الالكتروني</label>
                            <input type="email" required name="email" id="email"
                                placeholder="البريد الالكتروني">
                            <p class="error-message">هذا الحقل اجباري</p>
                            <x-input-error field="email" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-control">
                            <label for="password">كلمة السر</label>
                            <input type="password" required name="password" id="password" placeholder="كلمة السر">
                            <x-input-error field="password" />
                            <p class="error-message">هذا الحقل اجباري</p>
                        </div>

                    </div>
                    <button type="submit" class="submitBtn d-block mb-1 mt-1 m-auto">تسجيل الدخول</button>
                    <a href="reset_password.html" class="d-block m-auto t-center">إعادة تعيين كلمة السرّ</a>


                </form>
            </div>
        </div>
    </main>



</body>

</html>
