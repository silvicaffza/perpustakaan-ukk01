@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Riwayat Penolakan')

@section('content')

<style>
.card {
    background: #fff;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 10px 26px rgba(14, 60, 120, .08);
}

.card-title {
    font-weight: 800;
    font-size: 18px;
    color: #0b2a5b;
    margin-bottom: 18px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table thead {
    background: #f4f8ff;
}

.table th {
    text-align: left;
    padding: 12px;
    font-weight: 700;
    color: #0b2a5b;
}

.table td {
    padding: 12px;
    border-top: 1px solid rgba(21, 87, 176, .08);
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.rejected {
    background: #ffe6e6;
    color: #c0392b;
}

.reason-box {
    background:#fff5f5;
    border:1px solid #fecaca;
    padding:6px 10px;
    border-radius:8px;
    font-size:13px;
    color:#7f1d1d;
}
</style>

<div class="card">

    <div class="card-title">❌ Riwayat Penolakan</div>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Alasan</th>
            </tr>
        </thead>

        <tbody>

            @forelse($loans as $loan)

                <tr>
                    <td>
                        <strong>{{ $loan->user->name }}</strong>
                    </td>

                    <td>{{ $loan->book->title }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}
                    </td>

                    <td>
                        <span class="badge rejected">
                            Ditolak
                        </span>
                    </td>

                    <td>
                        <div class="reason-box">
                            {{ $loan->rejection_reason ?? '-' }}
                        </div>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5" style="text-align:center;">
                        Tidak ada data penolakan
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

@endsection