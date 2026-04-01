@extends('layouts.user')

@section('title', 'Beranda')

@section('content')

@php
    $activeLoans = $activeLoans ?? 0;
    $maxLoans = $maxLoans ?? 3;

    $percentage = $maxLoans > 0 ? ($activeLoans / $maxLoans) * 100 : 0;
    $percentage = min(100, $percentage);

    if ($activeLoans == $maxLoans) {
        $progressColor = '#ef4444';
    } elseif ($activeLoans >= ($maxLoans / 2)) {
        $progressColor = '#f59e0b';
    } else {
        $progressColor = '#22c55e';
    }
@endphp

{{-- ⛔ PRIORITAS: BLOCKED --}}
@if($blockedUntil)

    <div style="
        background:#fff3cd;
        border:1px solid #ffeeba;
        color:#856404;
        padding:14px 18px;
        border-radius:10px;
        margin-bottom:20px;
        font-weight:600;
    ">
        ⛔ Akun Anda sedang diblokir sampai
        <strong>{{ $blockedUntil->format('d M Y') }}</strong>
        karena keterlambatan pengembalian buku.
    </div>

{{-- 🔴 LATE --}}
@elseif($lateLoan)

    <div style="
        background:#fee2e2;
        border:1px solid #fecaca;
        color:#991b1b;
        padding:14px 18px;
        border-radius:10px;
        margin-bottom:20px;
        font-weight:600;
    ">
        ⚠ Anda memiliki buku yang terlambat dikembalikan.
        Segera ajukan pengembalian agar akun tidak diblokir.
    </div>

@endif


<!-- ================= HERO ================= -->
<div class="hero-section">

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>
            Halo, {{ auth()->user()->name }} 👋
        </h1>

        {{-- TEXT PINJAMAN --}}
        @if($activeLoans == 1)
            <p>Kamu sedang meminjam <b>1</b> buku 📚</p>
        @elseif($activeLoans > 1)
            <p>Kamu sedang meminjam <b>{{ $activeLoans }}</b> buku 📚</p>
        @else
            <p>Kamu belum meminjam buku apapun 📖</p>
        @endif

        {{-- DUE SOON --}}
        @if(!empty($dueSoon) && $dueSoon > 0)
            <p class="due-text">
                Jangan lupa dikembalikan {{ $dueSoon }} hari lagi ya!
            </p>
        @endif
    </div>

    <!-- PROGRESS -->
    <div class="loan-progress">

        <div class="progress-bar">
            <div class="progress-fill" style="
                width: {{ $percentage }}%;
                background: {{ $progressColor }};
            ">
            </div>
        </div>

        <p class="progress-text">
            {{ $activeLoans }} / {{ $maxLoans }} buku dipinjam
        </p>

        @if($activeLoans >= $maxLoans)
            <p class="loan-warning">
                ⚠️ Batas peminjaman tercapai
            </p>
        @endif

    </div>

</div>


<!-- ================= BUKU TERBARU ================= -->
<h2 class="page-title">Buku Terbaru</h2>

<div class="scroll-section">

    <button onclick="scrollLeftBooks()" class="scroll-btn left">◀</button>

    <div id="bookScroll" class="scroll-container">

        @foreach($latestBooks as $book)

            <div class="book-card">

                <div class="book-wrapper">

                    <img src="{{ $book->cover 
                        ? asset('storage/'.$book->cover) 
                        : 'https://via.placeholder.com/300x400?text=No+Cover' }}" 
                        class="book-image">

                    <div class="book-overlay">
                        <a href="{{ route('user.books.show', $book->id) }}" class="detail-btn">
                            Lihat Detail
                        </a>
                    </div>

                </div>

                <p class="book-title">
                    {{ Str::limit($book->title, 25) }}
                </p>

                <p class="book-author">
                    {{ $book->author }}
                </p>

                @php
                    $rating = round($book->reviews_avg_rating ?? 0);
                @endphp

                <div class="rating">

                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $rating ? '⭐' : '☆' }}
                    @endfor

                    <span class="rating-text">
                        {{ number_format($book->reviews_avg_rating ?? 0, 1) }}
                        • {{ $book->reviews_count }} ulasan
                    </span>

                </div>

            </div>

        @endforeach

    </div>

    <button onclick="scrollRightBooks()" class="scroll-btn right">▶</button>

</div>


<!-- ================= FAVORIT ================= -->
<h2 class="page-title">⭐ Buku Terfavorit</h2>

<div class="scroll-section">

    <button onclick="scrollLeftFavorit()" class="scroll-btn left">◀</button>

    <div id="favoritScroll" class="scroll-container">

        @foreach($favorit as $buku)

            <div class="book-card">

                <div class="book-wrapper">

                    @if(($buku->reviews_avg_rating ?? 0) >= 4.5)
                        <span class="badge-popular">🔥 Populer</span>
                    @endif

                    <img src="{{ $buku->cover 
                        ? asset('storage/'.$buku->cover) 
                        : 'https://via.placeholder.com/300x400?text=No+Cover' }}" 
                        class="book-image">

                    <div class="book-overlay">
                        <a href="{{ route('user.books.show', $buku->id) }}" class="detail-btn">
                            Lihat Detail
                        </a>
                    </div>

                </div>

                <p class="book-title">
                    {{ Str::limit($buku->title, 25) }}
                </p>

                <p class="book-author">
                    {{ $buku->author }}
                </p>

                @php
                    $rating = round($buku->reviews_avg_rating ?? 0);
                @endphp

                <div class="rating">

                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $rating ? '⭐' : '☆' }}
                    @endfor

                    <span class="rating-text">
                        {{ number_format($buku->reviews_avg_rating ?? 0, 1) }}
                        • {{ $buku->reviews_count }} ulasan
                    </span>

                </div>

            </div>

        @endforeach

    </div>

    <button onclick="scrollRightFavorit()" class="scroll-btn right">▶</button>

</div>




<!-- ================= SCRIPT ================= -->
<script>
function scrollLeftBooks() {
    document.getElementById('bookScroll')
        .scrollBy({ left: -400, behavior: 'smooth' });
}

function scrollRightBooks() {
    document.getElementById('bookScroll')
        .scrollBy({ left: 400, behavior: 'smooth' });
}

function scrollLeftFavorit() {
    document.getElementById('favoritScroll')
        .scrollBy({ left: -400, behavior: 'smooth' });
}

function scrollRightFavorit() {
    document.getElementById('favoritScroll')
        .scrollBy({ left: 400, behavior: 'smooth' });
}
</script>


<!-- ================= STYLE ================= -->
<style>
.hero-section {
    background: url('{{ asset('images/unduhan.jpg') }}') center/cover;
    border-radius: 20px;
    padding: 60px 40px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 50px;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .55);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-content h1 {
    font-size: 32px;
    margin-bottom: 15px;
}

.due-text {
    font-size: 15px;
    color: #D6C8BA;
}
.book-title{
    font-weight: 600
}

.book-author{
    color:  #0d31a5a1;
}
.scroll-section {
    position: relative;
    margin-bottom: 60px;
}

.scroll-container {
    display: flex;
    gap: 20px;
    overflow: hidden;
    scroll-behavior: smooth;
}

.scroll-btn {
    position: absolute;
    top: 40%;
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
    cursor: pointer;
    z-index: 10;
}

.scroll-btn.left { left: -15px; }
.scroll-btn.right { right: -15px; }

.book-card {
    min-width: 160px;
}

.book-wrapper {
    position: relative;
    height: 230px;
    border-radius: 15px;
    overflow: hidden;
}

.book-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .55);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: .3s;
}

.book-wrapper:hover .book-overlay {
    opacity: 1;
}

.detail-btn {
    background: #D6C8BA;
    color: #052659;
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}

.loan-progress {
    margin-top: 18px;
    max-width: 260px;
}

.progress-bar {
    height: 10px;
    background: rgba(255,255,255,.25);
    border-radius: 20px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
}

.progress-text {
    font-size: 13px;
    margin-top: 6px;
}

.loan-warning {
    font-size: 12px;
    color: #ffb4b4;
}
</style>

@endsection