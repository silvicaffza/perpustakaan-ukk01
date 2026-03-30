@extends('layouts.user')

@section('title', 'Landing')

@section('content')

<style>

/* HERO */
.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    margin-bottom: 80px;
}

.hero-text h1 {
    font-size: 40px;
    color: #1e3a8a;
    margin-bottom: 15px;
}

.hero-text p {
    color: #1e3a8a;
    line-height: 1.7;
}

.hero-img img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(59,130,246,0.15);
}


/* STATS */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 80px;
}

.stat-card {
    background: white;
    padding: 30px;
    border-radius: 18px;
    border: 1px solid var(--border);
    text-align: center;
    transition: .3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.06);
}

.stat-card h2 {
    font-size: 30px;
    color: #1e3a8a;
}

.stat-card p {
    color: #1e3a8a;
}


/* TITLE */
.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 15px;
}


/* SCROLL */
.scroll-wrapper {
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
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
    cursor: pointer;
    z-index: 10;
}

.scroll-left { left: -15px; }
.scroll-right { right: -15px; }


/* BOOK */
.book-item {
    min-width: 160px;
    flex-shrink: 0;
}

.book-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.book-image {
    width: 160px;
    height: 220px;
    object-fit: cover;
    border-radius: 12px;
    transition: .3s;
}

.book-wrapper:hover .book-image {
    transform: scale(1.05);
}

.book-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.55);
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
    background: white;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    color: #1e293b;
}

.book-title {
    font-size: 14px;
    font-weight: 600;
    margin-top: 10px;
    color: #1e3a8a;
}

.book-author {
    font-size: 12px;
    color: #64748b;
}


/* REVIEW */
.review-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.review-card {
    background: white;
    padding: 22px;
    border-radius: 16px;
    border: 1px solid var(--border);
    transition: .3s;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.06);
}

.review-text {
    color: #1e3a8a;
    margin-top: 10px;
}

.review-user {
    font-size: 13px;
    color: #1e3a8a;
    margin-top: 12px;
}


/* RESPONSIVE */
@media(max-width:800px){
    .hero { grid-template-columns: 1fr; }
    .stats { grid-template-columns: 1fr; }
}

</style>


{{-- HERO --}}
<div class="hero" id="home">
    <div class="hero-text">
        <h1>Perpustakaan Digital</h1>
        <p>
            RuangBaca adalah sistem perpustakaan digital yang memudahkan
            pengguna untuk menemukan, meminjam, dan memberikan ulasan buku.
        </p>
        <p>
            Temukan berbagai koleksi buku menarik dan bagikan pengalaman membaca Anda.
        </p>
    </div>

    <div class="hero-img">
        <img src="{{ asset('images/landing1.jpg') }}">
    </div>
</div>


{{-- STATS --}}
<div class="stats">
    <div class="stat-card">
        <h2>{{ $totalBuku }}</h2>
        <p>Total Buku</p>
    </div>

    <div class="stat-card">
        <h2>{{ $totalUser }}</h2>
        <p>Pengguna</p>
    </div>

    <div class="stat-card">
        <h2>{{ $totalPeminjaman }}</h2>
        <p>Peminjaman</p>
    </div>
</div>


{{-- FAVORIT --}}
<h2 class="page-title" id="books">Buku Terfavorit</h2>

<div class="scroll-wrapper">

    <button onclick="scrollLeftFavorit()" class="scroll-btn scroll-left">◀</button>

    <div id="favoritScroll" class="scroll-container">
        @foreach($favorit as $buku)
        <div class="book-item">
            <div class="book-wrapper">
                <img src="{{ asset('storage/' . $buku->cover) }}" class="book-image">
                <div class="book-overlay">
                    <a href="/login" class="detail-btn">Login untuk lihat</a>
                </div>
            </div>

            <p class="book-title">{{ Str::limit($buku->title,25) }}</p>
            <p class="book-author">{{ $buku->author }}</p>
        </div>
        @endforeach
    </div>

    <button onclick="scrollRightFavorit()" class="scroll-btn scroll-right">▶</button>
</div>


{{-- TERBARU --}}
<h2 class="page-title">Buku Terbaru</h2>

<div class="scroll-wrapper">

    <button onclick="scrollLeftBaru()" class="scroll-btn scroll-left">◀</button>

    <div id="baruScroll" class="scroll-container">
        @foreach($terbaru as $buku)
        <div class="book-item">
            <div class="book-wrapper">
                <img src="{{ asset('storage/' . $buku->cover) }}" class="book-image">
                <div class="book-overlay">
                    <a href="/login" class="detail-btn">Login untuk lihat</a>
                </div>
            </div>

            <p class="book-title">{{ Str::limit($buku->title,25) }}</p>
            <p class="book-author">{{ $buku->author }}</p>
        </div>
        @endforeach
    </div>

    <button onclick="scrollRightBaru()" class="scroll-btn scroll-right">▶</button>
</div>


{{-- REVIEW --}}
<h2 class="page-title" id="reviews">Ulasan Pengguna</h2>

<div class="review-grid">
@foreach($reviews as $review)
    <div class="review-card">

        <div>
            @for ($i = 1; $i <= 5; $i++)
                {{ $i <= $review->rating ? '⭐' : '☆' }}
            @endfor
        </div>

        <p class="review-text">
            {{ $review->comment ?? 'Pengguna memberi rating tanpa komentar.' }}
        </p>

        <div class="review-user">
            {{ $review->user->name }} • {{ $review->book->title }}
        </div>

    </div>
@endforeach
</div>


<script>
function scrollLeftFavorit(){document.getElementById('favoritScroll').scrollBy({left:-300,behavior:'smooth'})}
function scrollRightFavorit(){document.getElementById('favoritScroll').scrollBy({left:300,behavior:'smooth'})}
function scrollLeftBaru(){document.getElementById('baruScroll').scrollBy({left:-300,behavior:'smooth'})}
function scrollRightBaru(){document.getElementById('baruScroll').scrollBy({left:300,behavior:'smooth'})}
</script>

@endsection