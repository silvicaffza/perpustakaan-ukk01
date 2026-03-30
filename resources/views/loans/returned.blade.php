@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Riwayat Pengembalian')

@section('content')

<style>
.card{
    background:#ffffff;
    border-radius:20px;
    padding:28px;
    border:1px solid #e2e8f0;
    box-shadow:0 15px 35px rgba(37,99,235,.06);
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.card-title{
    font-weight:800;
    font-size:20px;
    color:#1e3a8a;
}

.badge-total{
    background:#dbeafe;
    color:#1e40af;
    padding:6px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
}

.table-wrapper{
    overflow-x:auto;
}

.table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.table thead{
    background:#f1f5f9;
}

.table th{
    text-align:left;
    padding:14px;
    font-weight:700;
    color:#1e3a8a;
    font-size:13px;
    letter-spacing:.3px;
}

.table td{
    padding:14px;
    border-top:1px solid #e2e8f0;
    color:#334155;
}

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#f8fafc;
}

.date{
    font-size:13px;
    color:#64748b;
}

.empty{
    text-align:center;
    padding:30px;
    color:#64748b;
    font-size:14px;
}
</style>

<div class="card">

    <div class="card-header">
        <div class="card-title">📚 Riwayat Buku Dikembalikan</div>
        <div class="badge-total">
            {{ $loans->count() }} Buku
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td><strong>{{ $loan->user->name }}</strong></td>
                    <td>{{ $loan->book->title }}</td>
                    <td class="date">
                        {{ \Carbon\Carbon::parse($loan->borrowed_at)->format('d M Y') }}
                    </td>
                    <td class="date">
                        {{ \Carbon\Carbon::parse($loan->returned_at)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty">
                        Belum ada buku yang dikembalikan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection