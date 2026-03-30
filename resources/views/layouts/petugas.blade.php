<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Petugas') - Perpustakaanku</title>

    <style>
        :root {

            --blue: #3b82f6;
            --blue-soft: #eaf2ff;
            --blue-dark: #1e40af;

            --bg: #f5f7fb;
            --sidebar: #ffffff;
            --border: #e6e8ec;

            --text: #1f2937;
            --text-soft: #6b7280;

            --hover: #f3f7ff;
            --active: #3b82f6;

            --radius: 12px;

        }

        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 260px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            padding: 20px 14px;

            height: 100vh;
            overflow-y: auto;

            position: sticky;
            top: 0;
            transition: .3s;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);

            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* BRAND */

        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 2px;
            margin-bottom: 28px;
        }

        .brand-title {
            font-weight: 700;
            font-size: 17px;
            color: var(--blue-dark);
        }

        .brand-sub {
            font-size: 12px;
            color: var(--text-soft);
        }

        /* NAV */

        .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-soft);
            font-size: 14px;
            cursor: pointer;
        }

        .dd-sum {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .nav a span,
        .dd-sum span {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .arrow {
            font-size: 11px;
            opacity: .6;
            transition: 0.2s;
        }

        .dd[open] .arrow {
            transform: rotate(180deg);
        }

        /* HOVER */

        .nav a:hover,
        .dd-sum:hover {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        /* ACTIVE */

        .active {
            background: var(--blue-soft);
            color: var(--blue-dark) !important;
            position: relative;
            font-weight: 600;
        }

        .active::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 6px;
            bottom: 6px;
            width: 4px;
            background: var(--blue);
            border-radius: 4px;
        }

        /* DROPDOWN */

        .dd summary {
            list-style: none;
        }

        .dd-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 6px;
            padding-left: 18px;
            border-left: 1px solid var(--border);
        }

        .dd-item a {
            background: transparent;
        }

        .dd-item a:hover {
            background: var(--hover);
        }

        .arrow {
            font-size: 11px;
            opacity: .7;
        }

        .dd[open] .arrow {
            transform: rotate(180deg);
        }

        /* COLLAPSED */

        .sidebar.collapsed .brand-title,
        .sidebar.collapsed .brand-sub,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .dd-item,
        .sidebar.collapsed .arrow {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        .sidebar.collapsed .nav a,
        .sidebar.collapsed .dd-sum {
            justify-content: center;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        /* FOOTER */

        .sidebar-footer {
            margin-top: auto;
            padding: 10px;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 12px;
            text-align: center;
            color: var(--text-soft);
        }

        /* ================= MAIN ================= */

        .main {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */

        .topbar {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-title {
            font-weight: 600;
            font-size: 17px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* USER */

        .pill {
            padding: 6px 12px;
            border-radius: 999px;
            background: #f3f4f6;
            font-size: 13px;
        }

        /* BUTTON */

        .btn {
            border: 1px solid var(--border);
            background: white;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            color: var(--text);
        }

        .btn-primary {
            background: var(--blue);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        /* CARD */

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* ALERT */

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
        }

        .content {
            margin-top: 18px;
        }
    </style>
</head>

<body>

    <div class="app">

        <aside class="sidebar" id="sidebar">

            <div class="brand">
                
                <div>
                    <div class="brand-title">Perpustakaanku</div>
                    <div class="brand-sub">Panel Petugas</div>
                </div>
            </div>

            <nav class="nav">

                <a href="/petugas/dashboard" class="{{ request()->is('*info*') ? 'active' : '' }}">
    
                    <span>

                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9L12 3L21 9V21H3V9Z" />
                        </svg>

                        <span class="nav-text">Dashboard</span>

                    </span>

                </a>

                @php
                    $akunActive = request()->is('*account-user*');
                @endphp

                <details class="dd" {{ $akunActive ? 'open' : '' }}>

                    <summary class="dd-sum {{ $akunActive ? 'active' : '' }}">

                        <span>

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="9" cy="7" r="4" />
                                <circle cx="17" cy="7" r="4" />
                                <path d="M3 21C3 16 7 14 9 14" />
                                <path d="M15 14C17 14 21 16 21 21" />
                            </svg>

                            <span class="nav-text">Manajemen Akun</span>

                        </span>

                        <span class="arrow">▾</span>

                    </summary>

                    <div class="dd-item">

                        <a href="{{ url('/account-user') }}"
                            class="{{ request()->is('*account-user*') ? 'active' : '' }}">

                            <span>

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="9" cy="7" r="4" />
                                    <circle cx="17" cy="7" r="4" />
                                    <path d="M3 21C3 16 7 14 9 14" />
                                    <path d="M15 14C17 14 21 16 21 21" />
                                </svg>

                                <span class="nav-text">Akun User</span>

                            </span>

                        </a>

                    </div>

                </details>

                @php
                    $bukuActive = request()->is('*categories*') || request()->is('*books*');
                @endphp

                <details class="dd" {{ $bukuActive ? 'open' : '' }}>

                    <summary class="dd-sum {{ $bukuActive ? 'active' : '' }}">

                        <span>

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5V4.5A2.5 2.5 0 016.5 2H20V22H6.5A2.5 2.5 0 014 19.5Z" />
                            </svg>

                            <span class="nav-text">Manajemen Buku</span>

                        </span>

                        <span class="arrow">▾</span>

                    </summary>

                    <div class="dd-item">

                        <a href="{{ route('categories.index') }}"
                            class="{{ request()->is('*categories*') ? 'active' : '' }}">

                            <span>

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M3 7L12 2L21 7L12 12L3 7Z" />
                                </svg>

                                <span class="nav-text">Data Kategori</span>

                            </span>

                        </a>

                        <a href="{{ route('books.index') }}" class="{{ request()->is('*books*') ? 'active' : '' }}">

                            <span>

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 19.5V4.5A2.5 2.5 0 016.5 2H20V22H6.5A2.5 2.5 0 014 19.5Z" />
                                </svg>

                                <span class="nav-text">Data Buku</span>

                            </span>

                        </a>

                    </div>

                </details>
                @php
                    $loanActive = request()->is('*loans*');
                @endphp

                <details class="dd" {{ $loanActive ? 'open' : '' }}>

                    <summary class="dd-sum {{ $loanActive ? 'active' : '' }}">

                        <span>

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="16" rx="2" />
                                <path d="M7 8H17" />
                                <path d="M7 12H17" />
                            </svg>

                            <span class="nav-text">Manajemen Peminjaman</span>

                        </span>

                        <span class="arrow">▾</span>

                    </summary>

                    <div class="dd-item">

                        <a href="{{ route('loans.index') }}" class="{{ request()->is('*loans') ? 'active' : '' }}">

                            <span>

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 15V6A2 2 0 0019 4H5A2 2 0 003 6V15" />
                                    <path d="M7 10H17" />
                                </svg>

                                <span class="nav-text">Pinjaman Aktif</span>

                            </span>

                        </a>

                        <a href="{{ route('loans.returned') }}"
                            class="{{ request()->is('*returned*') ? 'active' : '' }}">

                            <span>

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="9 11 12 14 22 4" />
                                    <path d="M21 12V19A2 2 0 0119 21H5A2 2 0 013 19V5A2 2 0 015 3H16" />
                                </svg>

                                <span class="nav-text">Riwayat Pinjaman</span>

                            </span>

                        </a>

                    </div>

                </details>
                @php
                    $laporanActive = request()->is('laporan/buku*')
                        || request()->is('laporan/user*')
                        || request()->is('laporan/peminjaman*')
                        || request()->is('laporan/pengembalian*')
                        || request()->is('laporan/penolakan*')
                ;@endphp

                <details class="dd" {{ $laporanActive ? 'open' : '' }}>
                    <summary class="dd-sum {{ $laporanActive ? 'active' : '' }}">
                        <span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 3V21H21" />
                                <path d="M7 14L12 9L16 13L21 8" />
                            </svg>
                            <span class="nav-text">Laporan</span>
                        </span>
                        <span class="arrow">▾</span>
                    </summary>

                    <div class="dd-item">

                        <a href="{{ route('laporan.buku') }}"
                            class="{{ request()->routeIs('laporan.buku') ? 'active' : '' }}">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 19.5V4.5A2.5 2.5 0 016.5 2H20V22H6.5A2.5 2.5 0 014 19.5Z" />
                                </svg>
                                <span class="nav-text">Laporan Buku</span>
                            </span>
                        </a>

                        <a href="{{ route('laporan.user') }}"
                            class="{{ request()->routeIs('laporan.user') ? 'active' : '' }}">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="9" cy="7" r="4" />
                                    <circle cx="17" cy="7" r="4" />
                                    <path d="M3 21C3 16 7 14 9 14" />
                                    <path d="M15 14C17 14 21 16 21 21" />
                                </svg>
                                <span class="nav-text">Laporan Akun User</span>
                            </span>
                        </a>

                        <a href="{{ route('laporan.peminjaman') }}"
                            class="{{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <path d="M7 8H17" />
                                </svg>
                                <span class="nav-text">Laporan Peminjaman</span>
                            </span>
                        </a>

                        <a href="{{ route('laporan.pengembalian') }}"
                            class="{{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="9 11 12 14 22 4" />
                                </svg>
                                <span class="nav-text">Laporan Pengembalian</span>
                            </span>
                        </a>

                        <a href="{{ route('laporan.penolakan') }}"
                            class="{{ request()->routeIs('laporan.penolakan') ? 'active' : '' }}">
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="9 11 12 14 22 4" />
                                </svg>
                                <span class="nav-text">Laporan Penolakan</span>
                            </span>
                        </a>

                    </div>
                </details>
            </nav>

            <div class="sidebar-footer">
                © {{ date('Y') }} Perpustakaanku
            </div>

        </aside>

        <div class="main">

            <header class="topbar">

                <div class="topbar-left">
                    <button onclick="toggleSidebar()" class="btn">☰</button>
                    <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
                </div>

                <div class="topbar-right">
                    <div class="pill">Halo, <b>{{ auth()->user()->name }}</b></div>

                    

                    <form method="POST" action="/logout" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>

                </div>

            </header>

            <main class="content">
                @yield('content')
            </main>

        </div>

    </div>



</body>

</html>