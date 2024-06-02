<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/imgs/favicon.png') }}">
    <title>كتابي - 403</title>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Stylesheets -->
    @vite('resources/sass/utilities.scss')
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Tajawal", sans-serif;

            background-color: hsl(180, 70%, 97%);
            min-height: 80vh;
        }

        .error-wrapper {
            text-align: center;
            padding-top: 3rem;
        }

        h1 {
            font-size: 45px;
            color: var(--clr-main-600);
            margin-block: 0;
        }

        p {
            line-height: 1.5;
            margin-block: 1rem 2rem;
            color: hsl(203, 82%, 23%);
            font-size: 22px;
            text-wrap: balance;
        }

        a {
            background-color: var(--clr-main-400);
            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 20px;
            letter-spacing: 1px;
            letter-spacing: 1px;
            padding: .5em 2em;
            text-decoration: none;
            color: var(--clr-white);
        }

        a:hover {
            background-color: hsl(190, 100%, 37%);
            border: 2px solid currentColor;
        }
    </style>


</head>


<body>
    <div class="error-wrapper">
        <h1>403 | ممنوع</h1>
        <p>عذرًا، لا تمتلك الصلاحيات للقيام بهذا. <br> يرجى التواصل مع المسؤول إذا كنت تعتقد أن هذا خطأ.
        </p>
        <a href="{{ url()->previous() }}">العودة</a>
    </div>
</body>

</html>
