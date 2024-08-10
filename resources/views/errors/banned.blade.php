<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/imgs/favicon.png') }}">
    <title>كتابي - الحساب محظور</title>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Stylesheets -->
    @vite('resources/sass/utilities.scss')
    <style>
        h1 {
            color: var(--clr-main-500);
            font-size: 22px;
        }

        .account-banned {
            background-color: var(--clr-blueGray-0);
            min-height: 100vh;
        }

        .account-banned-wrapper {
            width: min(600px, 95%);
            background-color: var(--clr-white-1000);
            padding: 1em 2em;
            letter-spacing: 1px;
            color: var(--clr-blueGray-900);
        }

        p.message {
            letter-spacing: 1px;
            line-height: 1.5;
            margin-top: .4em;
        }

        a {
            color: inherit;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
            transition: color .3s ease-in;
        }

        a:hover {
            color: var(--clr-teal-400);
        }



        button.logout-btn {
            text-decoration: underline;
            color: inherit;
            letter-spacing: inherit;
        }
    </style>


</head>


<body>
    <main class="account-banned d-flex j-center a-center">
        <div class="account-banned-wrapper shadow-1  radius-10">
            <h1>الحساب محظور</h1>
            <p class="message  ">
                عزيزي المستخدم،

                نود إبلاغك بأن حسابك على متجرنا الإلكتروني قد تم حظره نتيجة لانتهاك سياساتنا. إذا كنت تعتقد أن هناك خطأ
                أو لديك أي استفسارات حول هذا القرار، يُرجى <a href="{{ route('client.contact') }}">التواصل</a> معنا على
                الفور
                نحن هنا لمساعدتك ونقدر تفهمك وتعاونك.

            </p>


            <form action="{{ route('logout') }}" method="post" class="d-flex j-end mt-1">
                @csrf
                <button type="submit" class="logout-btn">الخروج</button>
            </form>

        </div>
    </main>
</body>

</html>
