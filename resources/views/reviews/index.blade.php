@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Daftar Ulasan Buku')

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
}

.card-title{
    font-weight:800;
    font-size:18px;
    color:#0b2a5b;
    margin-bottom:18px;
}

.table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.table thead{
    background:#f4f8ff;
}

.table th{
    text-align:left;
    padding:12px;
    font-weight:700;
    color:#0b2a5b;
}

.table td{
    padding:12px;
    border-top:1px solid rgba(21,87,176,.08);
    vertical-align:top;
}

.badge-rating{
    background:#fff4e6;
    color:#e67e22;
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.comment-box{
    background:#f9fafb;
    padding:8px 12px;
    border-radius:10px;
    font-size:13px;
    color:#374151;
    max-width:250px;
}
.empty{
    text-align:center;
    padding:20px;
    color:#64748b;
}
</style>

<div class="card">

    <div class="card-title">📝 Daftar Ulasan Buku</div>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr>
                <td><strong>{{ $review->user->name }}</strong></td>
                <td>{{ $review->book->title }}</td>
                <td>
                    <span class="badge-rating">
                        {{ $review->rating }} ⭐
                    </span>
                </td>
                <td>
                    <div class="comment-box">
                        {{ $review->comment ?? '-' }}
                    </div>
                </td>
                <td>{{ $review->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty">
                    Belum ada ulasan buku.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection