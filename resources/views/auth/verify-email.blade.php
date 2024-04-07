<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lalezar&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <title>كتابي - تأكيد البريد الالكتروني</title>
    @vite('resources/sass/utilities.scss')
    <style>
        .verify-email {
            background-color: var(--clr-blueGray-0);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background-image: url(../../assets/imgs/bg.jpg);
            background-size: cover;
        }

        .verify-email::after {
            position: absolute;
            content: '';
            inset: 0;
            backdrop-filter: blur(5px);
        }

        .verify-email-wrapper {
            z-index: 2;
            width: min(500px, 95%);
            background-color: var(--clr-white-1000);
            padding: 1em 2em;
            letter-spacing: 1px;
            color: var(--clr-blueGray-900);
        }

        p {
            font-weight: 500;
            color: var(--clr-blueGray-900);
            line-height: 1.5;
        }

        p.status-success {
            margin-bottom: 1em;
            background-color: var(--clr-green-400);
            color: var(--clr-white);
            padding: .65em;
            border-radius: 5px;
        }

        button.logout-btn {
            text-decoration: underline;
            color: inherit;
            letter-spacing: inherit;
            font-weight: 500;
        }

        .forms-holder {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1em;
            flex-wrap: wrap;
        }

        button.submitBtn {
            background-color: var(--clr-teal-300);
            color: var(--clr-white);
            padding: 0.65em 1em;
            border-radius: 5px;
            transition: background-color .3s ease;
        }

        button.submitBtn:hover {
            background-color: var(--clr-teal-200);
        }

        h1 {
            margin-block: 0.2em;
            color: var(--clr-teal-300);
            font-size: 25px;
        }
    </style>
</head>

<body>
    <main class="verify-email">
        <div class="verify-email-wrapper shadow-1  radius-10">
            <h1>شكرا لانضمامك</h1>
            <p class="thanks-message">
                هذه أخر مرحلة قبل المواصلة. هل يمكنك تأكيد بريدك الالكتروني عن طريق الرابط الذي ارسلناه
                الأن لبريدك الالكتروني ؟
                إن لم تتلقّى أيّ رابط يمكنك طلب إرسال رابط جديد من الزرّ بالأسفل
            </p>

            @if (session('status') == 'verification-link-sent')
                <p class="status-success mt-1 mb-1">
                    لقد قمنا للتوّ بإرسال رابط جديد لتأكيد بريدك الالكتروني
                </p>
            @endif

            <div class="mt-2 forms-holder">
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button type="submit" class="submitBtn">إرسال رابط جديد</button>
                </form>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn">خروج</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
