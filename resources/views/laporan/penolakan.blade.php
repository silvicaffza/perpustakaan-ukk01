@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Laporan Penolakan')

@section('content')

<style>
    .report-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .period-box {
        background: #f5f7fb;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 15px;
    }

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

    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #dc2626;
        color: white;
    }

    .btn-secondary {
        background: #e5e7eb;
    }

    .btn-print {
        background: #0f766e;
        color: white;
    }

    .total-box {
        float: right;
        background: #fee2e2;
        border: 1px solid #fecaca;
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    thead {
        background: #fef2f2;
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

    /* PRINT */

    .print-header,
    .print-info,
    .print-sign,
    .print-footer {
        display: none;
    }

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

        @page {
            margin: 25mm 20mm 35mm 20mm;
        }

        .print-header {
            display: block;
            text-align: center;
        }

        .print-line {
            border-top: 2px solid black;
            margin: 10px 0 15px 0;
        }

        .print-info {
            display: block;
            margin-bottom: 10px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .print-sign {
            display: block;
            margin-top: 60px;
            width: 250px;
            float: right;
            text-align: center;
        }

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
    Laporan Penolakan Peminjaman
</div>

<div class="total-box">
    Total Data : {{ $loans->count() }}
</div>

<div class="print-header">
    <h2>PERPUSTAKAAN</h2>
    <h3>LAPORAN PENOLAKAN PEMINJAMAN</h3>
</div>

<hr class="print-line">

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
                <b>{{ $loans->count() }}</b>
            </td>
        </tr>
        <tr>
            <td style="border:none">
                Laporan :
                <b>Penolakan Peminjaman</b>
            </td>
            <td style="border:none;text-align:right">
                Tanggal Cetak :
                <b>{{ now()->format('d M Y') }}</b>
            </td>
        </tr>
    </table>
</div>

<div class="period-box">
    Periode :
    <b>{{ $start ? \Carbon\Carbon::parse($start)->format('d M Y') : '-' }}</b>
    -
    <b>{{ $end ? \Carbon\Carbon::parse($end)->format('d M Y') : '-' }}</b>
</div>

<form method="GET" class="filter-bar">

    <label>Dari</label>
    <input type="date" name="start" value="{{ request('start') }}">

    <label>Sampai</label>
    <input type="date" name="end" value="{{ request('end') }}">

    <button class="btn btn-primary">Filter</button>

    <a href="{{ route('laporan.penolakan') }}" class="btn btn-secondary">
        Reset
    </a>

    <button onclick="window.print()" type="button" class="btn btn-print">
        🖨 Print 
    </button>

</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Akun</th>
            <th>Buku</th>
            <th>Tanggal Pengajuan</th>
            <th>Alasan Ditolak</th>
        </tr>
    </thead>

    <tbody>

        @forelse($loans as $loan)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->book->title }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}
                </td>

                <td>
                    {{ $loan->rejection_reason ?? '-' }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;color:#777">
                    Tidak ada data penolakan
                </td>
            </tr>

        @endforelse

    </tbody>
</table>

<div class="print-sign">
    Mengetahui,<br>
    Petugas Perpustakaan
    <br><br><br><br>
    (____________________)
</div>

<div class="print-footer"></div>

@endsection