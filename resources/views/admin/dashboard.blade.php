@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<h2 style="margin-bottom:15px;">Dashboard Admin</h2>

{{-- 📊 STATISTIK --}}
<div style="display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px;">

    <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">
        <div>Total User</div>
        <b style="font-size:20px;">{{ $totalUsers }}</b>
    </div>

    <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">
        <div>Total Buku</div>
        <b style="font-size:20px;">{{ $totalBooks }}</b>
    </div>

    <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">
        <div>Total Peminjaman</div>
        <b style="font-size:20px;">{{ $totalLoans }}</b>
    </div>

</div>

{{-- 📌 STATUS --}}
<div style="display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px;">

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Pending: <b>{{ $pendingLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Disetujui: <b>{{ $approvedLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Dipinjam: <b>{{ $borrowedLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Dikembalikan: <b>{{ $returnedLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Ditolak: <b>{{ $rejectedLoans }}</b>
    </div>

</div>

{{-- 📌 AKTIVITAS --}}
<div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">

    <h4 style="margin-bottom:10px;">Aktivitas Terbaru</h4>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:8px; border:1px solid #ddd;">User</th>
                <th style="padding:8px; border:1px solid #ddd;">Buku</th>
                <th style="padding:8px; border:1px solid #ddd;">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentLoans as $loan)
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{ $loan->user->name }}
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{ $loan->book->title }}
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{ ucfirst($loan->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center; padding:10px;">
                        Belum ada aktivitas
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection