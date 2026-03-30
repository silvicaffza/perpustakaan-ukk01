@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Laporan Pengembalian Buku')

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

.btn-primary { background: #2563eb; color: white; }
.btn-secondary { background: #e5e7eb; }
.btn-print { background: #0f766e; color: white; }

.total-box {
    float: right;
    clear: both;
    background: #eef2ff;
    border: 1px solid #c7d2fe;
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
    background: #f1f5f9;
}

th {
    font-weight: 600;
}

table th, table td {
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

    .topbar, .sidebar, form, .btn, .report-title, .period-box, .filter-bar, .total-box {
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

    .print-info {
        display: block;
        margin-bottom: 10px;
    }

    table {
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
    }

    table th, table td {
        border: 1px solid #000;
        padding: 6px;
    }

    thead {
        background: #fff;
        display: table-header-group;
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
    📚 Laporan Pengembalian Buku
</div>

<div class="total-box">
    Total Data : {{ $loans->count() }}
</div>

<div class="print-header">
    <h2>PERPUSTAKAAN DIGITAL</h2>
    <h3>LAPORAN PENGEMBALIAN BUKU</h3>
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
                <b>Pengembalian Buku</b>
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

    <button class="btn btn-primary">
        Filter
    </button>

    <a href="{{ route('laporan.pengembalian') }}" class="btn btn-secondary">
        Reset
    </a>

    <button onclick="window.print()" type="button" class="btn btn-print">
        🖨 Print / Save PDF
    </button>

</form>

<table>
    <thead>
        <tr>
            <th width="60">No</th>
            <th>User</th>
            <th>Buku</th>
            <th width="150">Tanggal Pinjam</th>
            <th width="150">Tanggal Kembali</th>
            <th width="120">Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($loans as $loan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $loan->user->name }}</td>
            <td>{{ $loan->book->title }}</td>

            <td>
                {{ $loan->borrowed_at 
                    ? \Carbon\Carbon::parse($loan->borrowed_at)->format('d M Y') 
                    : '-' }}
            </td>

            <td>
                {{ $loan->returned_at 
                    ? \Carbon\Carbon::parse($loan->returned_at)->format('d M Y') 
                    : '-' }}
            </td>

            <td>
                @if($loan->returned_at && $loan->due_date && $loan->returned_at > $loan->due_date)
                    <span style="color:red;font-weight:600;">Terlambat</span>
                @else
                    <span style="color:green;">Tepat Waktu</span>
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

<div class="print-sign">
    Mengetahui,<br>
    Petugas Perpustakaan

    <br><br><br><br>

    (____________________)
</div>

<div class="print-footer"></div>

@endsection