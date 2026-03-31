@extends('layouts.petugas')

@section('page_title', 'Beranda Petugas')

@section('content')

<h2 style="margin-bottom:15px;">Beranda Petugas</h2>

{{-- 📊 STATISTIK --}}
<div style="display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px;">

    <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">
        <div>Total Buku</div>
        <b style="font-size:20px;">{{ $totalBooks }}</b>
    </div>

    <div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">
        <div>Total Peminjaman</div>
        <b style="font-size:20px;">{{ $totalLoans }}</b>
    </div>

</div>

{{-- 📌 STATUS PEMINJAMAN --}}
<div style="display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px;">

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Menunggu Persetujuan: <b>{{ $pendingLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Disetujui: <b>{{ $approvedLoans }}</b>
    </div>

    <div style="background:#fff; padding:12px; border:1px solid #ddd; border-radius:6px;">
        Sedang Dipinjam: <b>{{ $borrowedLoans }}</b>
    </div>

</div>

{{-- 📌 AKTIVITAS TERBARU --}}
<div style="background:#fff; padding:15px; border-radius:8px; border:1px solid #ddd;">

    <h4 style="margin-bottom:10px;">Aktivitas Terbaru</h4>

    @php
        $statusText = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'borrowed' => 'Sedang Dipinjam',
            'returned' => 'Sudah Dikembalikan',
            'rejected' => 'Ditolak',
        ];
    @endphp

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:8px; border:1px solid #ddd;">Nama Pengguna</th>
                <th style="padding:8px; border:1px solid #ddd;">Judul Buku</th>
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
                        {{ $statusText[$loan->status] ?? $loan->status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center; padding:10px;">
                        Belum ada aktivitas terbaru
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection