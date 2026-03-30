<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User') - RuangBaca</title>

    <!-- ICON -->
    <link href="https://fonts.googleapis.com/css2?family=Leckerli+One&display=swap" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            --primary: #3B82F6;
            --mid: #60A5FA;
            --light: #EFF6FF;

            --bg: #f4f8fc;
            --text: #1e293b;
            --muted: #64748b;
            --card: #ffffff;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(180deg, #f8fbff, #eef5ff);
            color: var(--text);
        }

        /* NAVBAR */

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .nav-inner {
            max-width: 1200px;
            margin: auto;
            padding: 18px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* LOGO */
        .logo {
            font-family: 'Leckerli One', cursive;
            font-size: 24px;
            color: var(--primary);
            /* Ruang */
        }

        .logo span {
            color: var(--primary);
            /* Baca */
        }

        /* MENU */

        .menu {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .menu a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 500;
            font-size: 14px;
            position: relative;
            transition: all .2s ease;
        }

        .menu a:hover {
            color: var(--primary);
        }

        .menu a::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--primary);
            border-radius: 10px;
            transition: .3s;
        }

        .menu a:hover::after {
            width: 100%;
        }

        /* RIGHT */

        .user-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* BUTTON */

        .btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: .25s;
        }

        .btn-login {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-login:hover {
            background: var(--light);
        }

        .btn-register {
            background: var(--primary);
            color: white;
        }

        .btn-register:hover {
            background: var(--mid);
        }

        .btn {
            border: none;
            outline: none;
        }

        /* USER PILL */

        .pill {
            background: var(--light);
            color: var(--primary);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* CONTENT */

        .container {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
            color: #1e3a8a;
            line-height: 1.6;
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--primary);
        }

        /* CARD */

        .card {
            background: var(--card);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--border);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
        }

        /* FOOTER */

        .footer {
            margin-top: 100px;
            background: white;
            border-top: 1px solid var(--border);
            color: #1e3a8a;
            padding: 30px 20px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <div class="navbar">
        <div class="nav-inner">

            <div class="logo">
                RuangBaca
            </div>
            <div class="menu">

                @guest
                    <a href="#home">Home</a>
                    <a href="#books">Buku</a>
                    <a href="#reviews">Ulasan</a>
                @endguest

                @auth
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    <a href="{{ route('user.books.index') }}">Buku</a>
                    <a href="{{ route('user.koleksi.index') }}">Koleksi</a>
                    <a href="{{ route('user.loans.index') }}">Peminjaman</a>
                @endauth

            </div>

            <div class="user-right">

                @guest
                    <a href="/login" class="btn btn-login">Login</a>
                    <a href="/register" class="btn btn-register">Register</a>
                @endguest

                @auth
                    <div class="pill">
                        Halo, <b>{{ auth()->user()->name }}</b>
                    </div>

                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="btn btn-register">Logout</button>
                    </form>
                @endauth

            </div>

        </div>
    </div>

    <!-- CONTENT -->

    <div class="container">
        @yield('content')
    </div>

    <!-- FOOTER -->

    <div class="footer">
        © {{ date('Y') }} RuangBaca • Sistem Informasi Perpustakaan
    </div>

</body>

</html>