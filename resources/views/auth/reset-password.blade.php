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
    <title>كتابي - كلمة مرور جديدة</title>
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


        .reset-password .form-wrapper {
            width: min(600px, 90%);
            background-color: var(--clr-white);
            padding: 2em;
            border-radius: 10px;
            z-index: 1;
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }

        .reset-password .form-wrapper h1 {
            color: var(--clr-teal-300);
            font-size: 30px;
        }

        .reset-password .form-wrapper>p {
            color: var(--clr-navy-200);
            letter-spacing: 1px;
            line-height: 1.7;
            margin-block: 0.5em;
        }




        .reset-password .form-wrapper form .form-control input {
            width: 100%;
            height: 45px;
            padding-inline: 1em;
            border-radius: 5px;
            border: 2px solid transparent;
            background-color: var(--clr-black-950);
            color: var(--clr-blueGray-900);
            outline: none;
            margin-top: .5em;
        }

        .reset-password .form-wrapper form .form-control input:focus,
        .reset-password .form-wrapper form .form-control input:focus-within {
            border-color: var(--clr-blueGray-500);
            /* border-color: red !important; */

        }

        .reset-password .form-wrapper form .form-control p.message {
            margin-block: 0.3em;
            margin-inline: 0.2em;
            line-height: 1.7;
            letter-spacing: 1px;
            transition: display .3s ease;
            display: none;
        }

        .reset-password .form-wrapper form .form-control p.message.show {
            display: block;
            font-weight: 500;
        }

        .reset-password .form-wrapper form .form-control p.message.error {
            color: var(--clr-red-600);
        }

        .reset-password .form-wrapper form .form-control p.message.success {
            margin-bottom: 1em;
            background-color: var(--clr-green-400);
            color: var(--clr-white);
            padding: .65em;
            border-radius: 5px;
        }



        .reset-password .form-wrapper form .buttons button {
            background-color: var(--clr-teal-400);
            margin-block: 1em 0;
            padding: 0.7em 2em;
            color: var(--clr-white-1000);
            font-weight: bold;
            letter-spacing: 2px;
            border-radius: 5px;
            transition: background-color .3s ease;
        }

        .reset-password .form-wrapper form .buttons button:hover {
            background-color: var(--clr-teal-300);
        }

        p.message {
            color: var(--clr-red-600);
            margin-top: 5px;
            display: none;
        }

        label {
            color: var(--clr-blueGray-900);
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <main class="reset-password ">
        <div class="form-wrapper">
            <h1>كلمة مرور جديدة</h1>



            <form action="{{ route('password.store') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="form-control mb-1 mt-1">
                    <label for="email" class="d-block">البريد الالكتروني</label>
                    <input type="email" class="form-element" name="email" id="email"
                        placeholder="eg: joe@email.com" required>

                    @if ($errors->has('email'))
                        @foreach ($errors->get('email') as $error)
                            <p class="message error show"> {{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-control mb-1">
                    <label for="" class="d-block">كلمة المرور الجديدة</label>
                    <input type="password" name="password" id="password" placeholder="كلمة المرور" required>
                    @if ($errors->has('password'))
                        @foreach ($errors->get('password') as $error)
                            <p class="message error show"> {{ $error }}</p>
                        @endforeach
                    @endif

                </div>
                <div class="form-control">
                    <label for="password-confirmation" class="d-block">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password-confirmation"
                        placeholder="تأكيد كلمة المرور" required>



                </div>
                <div class="buttons d-flex j-end">
                    <button type="submit">إرسال</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
