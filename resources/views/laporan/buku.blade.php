@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Laporan Data Buku')

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

        .filter-bar input {
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

        .print-header,
        .print-info,
        .print-sign,
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

            /* margin halaman */

            @page {
                margin: 25mm 20mm 35mm 20mm;
            }

            /* HEADER */

            .print-header {
                display: block;
                margin-bottom: 5px;
                text-align: center;
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

            /* SIGN */

            .print-sign {
                display: block;
                margin-top: 60px;
                width: 250px;
                float: right;
                text-align: center;
            }

            /* FOOTER */

            .print-footer {
                display: block;
                position: fixed;
                bottom: 15px;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 11px;
            }

            .print-footer::after {
                counter-increment: page;
                content: "Halaman " counter(page);
            }

        }
    </style>


    <div class="report-title">
        Laporan Data Buku
    </div>

    <div class="total-box">
        Total Data : {{ $books->count() }} Buku
    </div>


    <!-- HEADER PRINT -->

    <div class="print-header">
        <h2>PERPUSTAKAAN</h2>
        <h3>LAPORAN DATA BUKU</h3>
    </div>

    <hr class="print-line">


    <!-- INFO PRINT -->

    <div class="print-info">

        <table style="width:100%;border:none;font-size:12px">

            <tr>

                <td style="border:none">
                    Periode :
                    <b>{{ $start ? \Carbon\Carbon::parse($start)->format('d M Y') : '-' }}</b>
                    -
                    <b>{{ $end ? \Carbon\Carbon::parse($end)->format('d M Y') : '-' }}</b>
                </td>

                <td style="border:none;text-align:right">
                    Total Data :
                    <b>{{ $books->count() }}</b>
                </td>

            </tr>

            <tr>

                <td style="border:none">
                    Laporan :
                    <b>Data Buku Perpustakaan</b>
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

        <button class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('laporan.buku') }}" class="btn btn-secondary">
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
                <th width="60">No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th width="100">Stok</th>
                <th width="150">Tanggal</th>
            </tr>
        </thead>

        <tbody>

            @forelse($books as $buku)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td><strong>{{ $buku->title }}</strong></td>

                    <td>

                        @forelse($buku->categories as $cat)
                            {{ $cat->name }}@if(!$loop->last), @endif
                        @empty
                            -
                        @endforelse

                    </td>

                    <td>{{ $buku->stock }}</td>

                    <td>{{ $buku->created_at->format('d M Y') }}</td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" style="text-align:center;color:#777">
                        Tidak ada data
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    <!-- SIGN -->

    <div class="print-sign">

        Mengetahui,<br>
        Petugas Perpustakaan

        <br><br><br><br>

        (____________________)

    </div>


    <!-- FOOTER HALAMAN -->

    <div class="print-footer"></div>

@endsection