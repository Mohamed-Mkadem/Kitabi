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
    <title>كتابي - إعادة تعيين كلمة المرور</title>
    @vite('resources/sass/utilities.scss')
    <style>
        .reset-password {
            background-color: var(--clr-blueGray-0);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background-image: url(../../assets/imgs/bg.jpg);
            background-size: cover;
        }

        .reset-password::after {
            position: absolute;
            content: '';
            inset: 0;
            backdrop-filter: blur(5px);
        }

        .form-wrapper {
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

        p.message {
            margin-bottom: 1em;
            color: var(--clr-white);
            padding: .65em;
            border-radius: 5px;
        }

        p.message.success {
            margin-bottom: 1em;
            background-color: var(--clr-green-400);
            color: var(--clr-white);
            padding: .65em;
            border-radius: 5px;
        }

        p.message.error {
            margin-bottom: 1em;
            background-color: var(--clr-red-500);
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



        button.submitBtn {
            background-color: var(--clr-teal-300);
            color: var(--clr-white);
            padding: 0.65em 1em;
            border-radius: 5px;
            transition: background-color .3s ease;
        }

        input {
            border: 1px solid var(--clr-black-850) !important;
            margin-block: 1em;
            width: 100%;
            transition: border-color .3s ease;
        }

        input:focus,
        input:focus-visible {
            border-color: var(--clr-teal-300) !important;
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
    <main class="reset-password d-flex j-center a-center">
        <div class="form-wrapper">
            <h1>إعادة تعيين كلمة المرور</h1>
            @include('components.errors')
            <p>نسيت كلمة مرورك ؟ لا مشكلة. فقط ضع بريدك الالكتروني وسنرسل لك رابطا لتعيين كلمة مرور جديدة</p>
            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="form-control">
                    <input type="email" name="email" placeholder="eg: joe@email.com" required>
                </div>
                @if ($errors->has('email'))
                    @foreach ($errors->get('email') as $error)
                        <p class="message error"> {{ $error }}</p>
                    @endforeach
                @endif
                @if (session()->has('status'))
                    <p class="message success">تم إرسال الرابط بنجاح</p>
                @endif

                <div class="buttons d-flex j-end">
                    <button type="submit" class="submitBtn">إرسال</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
