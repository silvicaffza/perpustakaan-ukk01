@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Laporan Akun')

@section('content')

    <style>
        /* ===== TITLE ===== */

        .report-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* ===== PERIODE BOX ===== */

        .period-box {
            background: #f5f7fb;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 15px;
        }

        /* ===== FILTER ===== */

        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-bar input,
        .filter-bar select {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        /* ===== BUTTON ===== */

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
        }

        .btn-print {
            background: #0f766e;
            color: white;
        }

        /* ===== TOTAL BOX ===== */

        .total-box {
            float: right;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* ===== TABLE ===== */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #f1f5f9;
        }

        th {
            font-weight: 600;
        }

        table th,
        table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== PRINT SECTION ===== */

        .print-header {
            display: none;
            text-align: center;
        }

        .print-info {
            display: none;
        }

        .print-sign {
            display: none;
        }

        .print-footer {
            display: none;
        }

        /* ===== PRINT MODE ===== */

        @media print {

            .topbar,
            .sidebar,
            form,
            .btn,
            .report-title,
            .period-box,
            .filter-bar,
            .total-box {
                display: none;
            }

            body {
                background: white;
                font-size: 12px;
                font-family: "Times New Roman", Times, serif;
                 counter-reset: page;
            }

            /* Margin halaman */

            @page {
                margin: 25mm 20mm 35mm 20mm;
            }

            /* HEADER */

            .print-header {
                display: block;
                margin-bottom: 5px;
            }

            .print-header h2 {
                margin: 0;
                font-size: 18px;
            }

            .print-header h3 {
                margin: 4px 0;
                font-size: 16px;
            }

            .print-line {
                border-top: 2px solid black;
                margin: 10px 0 15px 0;
            }

            /* INFO */

            .print-info {
                display: block;
                margin-bottom: 10px;
            }

            /* TABLE */

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 6px;
            }

            thead {
                background: #fff;
                display: table-header-group;
            }

            /* SIGNATURE */

            .print-sign {
                display: block;
                margin-top: 60px;
                width: 250px;
                float: right;
                text-align: center;
            }

            /* FOOTER HALAMAN */
.print-footer{
    display:block;
    position:fixed;
    bottom:15px;
    left:0;
    right:0;
    text-align:center;
    font-size:11px;
}

.print-footer::after{
    counter-increment: page;
    content:"Halaman " counter(page);
}

        }
    </style>


    <div class="report-title">
        Laporan Data Akun
    </div>

    <div class="total-box">
        Total Data : {{ $users->count() }}
    </div>


    <!-- HEADER PRINT -->

    <div class="print-header">
        <h2>PERPUSTAKAAN</h2>
        <h3>LAPORAN DATA AKUN</h3>
    </div>

    <hr class="print-line">


    <!-- INFO PRINT -->

    <div class="print-info">

        <table style="width:100%;border:none;font-size:12px">

            <tr>

                <td style="border:none">
                    Jenis Akun :
                    <b>
                        @if($role == 'admin')
                            Admin
                        @elseif($role == 'petugas')
                            Petugas
                        @elseif($role == 'user')
                            User
                        @else
                            Semua Akun
                        @endif
                    </b>
                </td>

                <td style="border:none;text-align:right">
                    Total Data :
                    <b>{{ $users->count() }}</b>
                </td>

            </tr>

            <tr>

                <td style="border:none">
                    Periode :
                    <b>{{ $start ? \Carbon\Carbon::parse($start)->format('d M Y') : '-' }}</b>
                    -
                    <b>{{ $end ? \Carbon\Carbon::parse($end)->format('d M Y') : '-' }}</b>
                </td>

                <td style="border:none;text-align:right">
                    Tanggal Cetak :
                    <b>{{ now()->format('d M Y') }}</b>
                </td>

            </tr>

        </table>

    </div>


    <!-- PERIODE WEB -->

    <div class="period-box">
        Periode :
        <b>{{ $start ? \Carbon\Carbon::parse($start)->format('d M Y') : '-' }}</b>
        -
        <b>{{ $end ? \Carbon\Carbon::parse($end)->format('d M Y') : '-' }}</b>
    </div>


    <!-- FILTER -->

    <form method="GET" class="filter-bar">

        <label>Dari</label>
        <input type="date" name="start" value="{{ request('start') }}">

        <label>Sampai</label>
        <input type="date" name="end" value="{{ request('end') }}">

        <label>Role</label>

        <select name="role">

            <option value="">Semua</option>

            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                Admin
            </option>

            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>
                User
            </option>

            <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>
                Petugas
            </option>

        </select>

        <button class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('laporan.user') }}" class="btn btn-secondary">
            Reset
        </a>

        <button onclick="window.print()" type="button" class="btn btn-print">
            🖨 Print / Save PDF
        </button>

    </form>


    <!-- TABLE -->

<table>

    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Tanggal Daftar</th>
            <th>Jumlah Keterlambatan</th> {{-- 🔥 tambahan --}}
        </tr>
    </thead>

    <tbody>

        @forelse($users as $user)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td><strong>{{ $user->name }}</strong></td>

                <td>{{ $user->email }}</td>

                <td>{{ ucfirst($user->role) }}</td>

                <td>{{ $user->created_at->format('d M Y') }}</td>

                <td>
                    @if($user->role === 'user')

                        @php
                            $lateCount = $user->loans
                                ->whereNotNull('returned_at')
                                ->filter(function($loan){
                                    return $loan->returned_at > $loan->due_date;
                                })
                                ->count();
                        @endphp

                        @if($lateCount > 0)
                            <span style="color:red; font-weight:600;">
                                {{ $lateCount }} kali
                            </span>
                        @else
                            <span style="color:green;">
                                0 (Tepat Waktu)
                            </span>
                        @endif

                    @else
                        -
                    @endif
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6" style="text-align:center;color:#777">
                    Tidak ada data
                </td>
            </tr>

        @endforelse

    </tbody>

</table>


    <!-- SIGNATURE -->

    <div class="print-sign">

        Mengetahui,<br>
        Petugas Perpustakaan

        <br><br><br><br>

        (____________________)

    </div>


    <!-- FOOTER HALAMAN -->

    <div class="print-footer"></div>

@endsection