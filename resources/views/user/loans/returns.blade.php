@extends('layouts.user')

@section('title', 'Pengembalian Buku')

@section('content')

<style>
.page-title {
    text-align: center;
    font-size: 30px;
    font-weight: 800;
    margin-bottom: 24px;
    color: #0f172a;
}

.loan-nav {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 25px;
}

.loan-tab {
    padding: 8px 16px;
    border-radius: 999px;
    background: #e2e8f0;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    transition: .2s;
}

.loan-tab:hover {
    background: #cbd5f5;
}

.loan-tab.active {
    background: #1f6feb;
    color: white;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    text-align: left;
    padding: 12px;
    background: #f1f5f9;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-warning {
    background: #fef9c3;
    color: #854d0e;
}

.loan-btn {
    padding: 6px 12px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
}

.loan-btn-primary {
    background: #1f6feb;
    color: white;
}

.loan-btn-success {
    background: #dcfce7;
    color: #166534;
}

.empty-text {
    text-align: center;
    color: #64748b;
}
</style>

<div class="page-title">
    🔄 Pengembalian Buku
</div>

<div class="loan-nav">
    <a href="{{ route('user.loans.index') }}"
        class="loan-tab {{ request()->routeIs('user.loans.index') ? 'active' : '' }}">
        📚 Dipinjam
    </a>

    <a href="{{ route('user.loans.returns') }}"
        class="loan-tab {{ request()->routeIs('user.loans.returns') ? 'active' : '' }}">
        🔄 Pengembalian
    </a>

    <a href="{{ route('user.loans.history') }}"
        class="loan-tab {{ request()->routeIs('user.loans.history') ? 'active' : '' }}">
        📖 Riwayat
    </a>
</div>

<div class="card">

    <table class="table">
        <thead>
            <tr>
                <th>Buku</th>
                <th>Status</th>
                <th>Tanggal Ajukan</th>
                <th>Bukti</th>
            </tr>
        </thead>

        <tbody>

            @forelse($loans as $loan)

                <tr>

                    <td>{{ $loan->book->title }}</td>
<td>
    @if($loan->status == 'borrowed')
        <span class="badge badge-warning">
            Menunggu Konfirmasi Admin
        </span>
    @elseif($loan->status == 'returned')
        <span class="badge badge-success">
            Sudah Dikembalikan
        </span>
    @endif
</td>

                    <td>
    {{ $loan->return_requested_at 
        ? \Carbon\Carbon::parse($loan->return_requested_at)->format('d M Y') 
        : '-' }}
</td>

                   <td style="display:flex; gap:6px; flex-wrap:wrap;">

    {{-- 📄 Bukti Pinjam --}}
    @if(in_array($loan->status, ['approved','borrowed','returned']))
        <a href="{{ route('user.loan.pdf', $loan->id) }}"
            class="loan-btn"
            style="background:#e0f2fe; color:#0369a1;">
            📄 Pinjam
        </a>
    @endif

    {{-- 📄 Bukti Pengembalian --}}
    @if($loan->status == 'returned')
        <a href="{{ route('user.loan.return.pdf', $loan->id) }}"
            class="loan-btn loan-btn-success">
            📄 Pengembalian
        </a>
    @endif

</td>
                </tr>

            @empty

                <tr>
                    <td colspan="4" class="empty-text">
                        Tidak ada pengajuan pengembalian
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

@endsection