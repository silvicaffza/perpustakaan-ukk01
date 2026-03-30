@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp


@extends($layout)

@section('page_title','Detail Buku')

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
}
.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
}
.card-title{
    font-weight:800;
    font-size:18px;
    color:#0b2a5b;
}
.btn-primary{
    background:#1f6feb;
    color:#fff;
    padding:8px 14px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}
.btn-primary:hover{
    opacity:.9;
}
.card-body{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}
.card-body .cover{
    flex: 0 0 200px;
}
.card-body .cover img{
    width:100%;
    border-radius:12px;
    object-fit:cover;
}
.card-body .details{
    flex:1;
}
.card-body .details p{
    font-size:15px;
    margin:8px 0;
}
.badge{
    display:inline-block;
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:#e6f0ff;
    color:#1557b0;
    margin:2px 2px 0 0;
}
.stock{
    font-weight:700;
}
.stock.low{
    color:#c0392b;
}
.stock.good{
    color:#1e7e34;
}
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title">Detail Buku</div>
        <a href="{{ route('books.index') }}" class="btn-primary">Kembali</a>
    </div>

    <div class="card-body">
        <!-- Cover Buku -->
        <div class="cover">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" alt="Cover {{ $book->title }}">
            @else
                <img src="{{ asset('images/default-cover.png') }}" alt="Cover default">
            @endif
        </div>

        <!-- Detail Buku -->
        <div class="details">
            <p><strong>Judul:</strong> {{ $book->title }}</p>
            <p><strong>Penulis:</strong> {{ $book->author }}</p>
            <p><strong>Penerbit:</strong> {{ $book->publisher ?? '-' }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $book->year ?? '-' }}</p>
            <p><strong>Stok:</strong> 
                <span class="stock {{ $book->stock <= 3 ? 'low' : 'good' }}">
                    {{ $book->stock }}
                </span>
            </p>
            <p><strong>Kategori:</strong>
                @forelse($book->categories as $cat)
                    <span class="badge">{{ $cat->name }}</span>
                @empty
                    -
                @endforelse
            </p>
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $book->description ?? '-' }}</p>
        </div>
    </div>
</div>

@endsection