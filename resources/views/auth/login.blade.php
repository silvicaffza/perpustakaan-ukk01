<!doctype html>

<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Perpustakaanku</title>

    <style>
        :root {
            --primary: #052659;
            --soft: #C1E8FF;
            --border: #e2e8f0;
            --muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        /* BODY */

        body {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: pageEnter .5s ease forwards;
        }

        /* PAGE ENTER */

        @keyframes pageEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* PAGE EXIT */

        .page-exit {
            opacity: 0;
            transform: translateY(-20px);
            transition: .35s;
        }

        /* LEFT IMAGE */

        .auth-image {
            background: url('{{ asset('images/landing1.jpg') }}') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: end;
            padding: 50px;
            color: white;
        }

        .auth-overlay {
            background: rgba(5, 38, 89, .65);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .auth-text {
            position: relative;
            z-index: 2;
            max-width: 400px;
        }

        .auth-text h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .auth-text p {
            font-size: 15px;
            opacity: .9;
            line-height: 1.6;
        }

        /* RIGHT FORM */

        .auth-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 80px;
            background: white;
        }

        /* FORM BOX */

        .form-box {
            width: 100%;
            max-width: 360px;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 6px;
            text-align: center;
        }

        .auth-sub {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 28px;
            text-align: center;
        }

        /* FORM */

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 14px;
            transition: .2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(5, 38, 89, .08);
        }

        /* PASSWORD */

        .password-wrapper {
            position: relative;
        }

        .toggle-pass {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 13px;
            color: var(--muted);
        }

        /* BUTTON */

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 38, 89, .2);
        }

        /* FOOTER */

        .auth-footer {
            margin-top: 18px;
            font-size: 14px;
            text-align: center;
            color: var(--muted);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* BACK BUTTON */

        .back {
            position: absolute;
            top: 30px;
            left: 40px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            z-index: 3;
        }

        /* ERROR */

        .error {
            background: #ffe4e6;
            color: #b91c1c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        /* RESPONSIVE */

        @media(max-width:900px) {

            body {
                grid-template-columns: 1fr;
            }

            .auth-image {
                height: 260px;
            }

            .auth-form {
                padding: 40px;
            }

        }
    </style>

</head>

<body>

    <a href="/" class="back">← Kembali</a>

    <!-- LEFT IMAGE -->

    <div class="auth-image">

        <div class="auth-overlay"></div>

        <div class="auth-text">
            <h2>Perpustakaanku</h2>
            <p>
                Temukan buku favoritmu dan nikmati pengalaman membaca
                yang lebih mudah dengan sistem perpustakaan digital.
            </p>
        </div>

    </div>

    <!-- RIGHT FORM -->

    <div class="auth-form">

        <div class="form-box">

            <div class="auth-title">Login</div>
            <div class="auth-sub">Masuk ke akun perpustakaan</div>

            @if ($errors->any())

                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>

                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-pass" onclick="togglePass()">👁</span>
                    </div>

                </div>

                <button type="submit" class="btn">
                    Login
                </button>

            </form>

            <div class="auth-footer">
                Belum punya akun?
                <a href="/register">Register</a>
            </div>

        </div>

    </div>

    <script>

        function togglePass() {
            let input = document.getElementById("password");

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

    </script>

    <script>

        document.querySelectorAll('a').forEach(link => {

            link.addEventListener('click', function (e) {

                let url = this.getAttribute('href');

                if (url && !url.startsWith('#') && !url.startsWith('javascript')) {

                    e.preventDefault();

                    document.body.classList.add('page-exit');

                    setTimeout(() => {
                        window.location.href = url;
                    }, 300);

                }

            });

        });

    </script>

</body>

</html>