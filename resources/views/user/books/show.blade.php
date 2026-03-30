@extends('layouts.user')

@section('title', 'Detail Buku')

@section('content')

    <style>
        .detail-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .btn-wishlist {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        .btn-wishlist:hover {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        /* CARD */

        .card {
            background: #fff;
            padding: 22px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
        }

        /* COVER */

        .cover-card {
            grid-row: span 2;
        }

        .book-cover {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* INFO */

        .book-info h2 {
            margin-bottom: 15px;
        }

        .meta {
            margin-bottom: 8px;
            color: #475569;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #e0f2fe;
            color: #0369a1;
            margin-right: 5px;
        }

        /* RATING */
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input input {
    display: none;
}

.rating-input label {
    font-size: 20px;
    color: #ccc;
    cursor: pointer;
    transition: 0.2s;
}

/* hover effect */
.rating-input label:hover,
.rating-input label:hover ~ label {
    color: #f59e0b;
}

/* selected */
.rating-input input:checked ~ label {
    color: #f59e0b;
}

        /* REVIEW */

        .review-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        /* BUTTON */

        .btn-primary {
            margin-top: 10px;
            background: #1f6feb;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-weight: 600;
        }

        /* REKOMENDASI */

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .book-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            transition: .3s;
            text-decoration: none;
            color: inherit;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .book-card-body {
            padding: 12px;
        }

        .book-card-title {
            font-size: 14px;
            font-weight: 700;
        }

        .book-card-author {
            font-size: 12px;
            color: #64748b;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #1f6feb;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            color: #94a3b8;
        }

        .btn-wishlist.active {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
    @if(session('success'))
        <div style="
                background:#dcfce7;
                color:#166534;
                padding:12px 16px;
                border-radius:10px;
                margin-bottom:20px;
                font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="
                background:#fee2e2;
                color:#991b1b;
                padding:12px 16px;
                border-radius:10px;
                margin-bottom:20px;
                font-weight:600;">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="breadcrumb">

            <a href="{{ route('user.dashboard') }}">
                Dashboard
            </a>

            <span>/</span>

            <a href="{{ route('user.books.index') }}">
                Books
            </a>

            <span>/</span>

            <span>Detail Buku</span>

        </div>

        <div class="detail-grid">

            {{-- COVER --}}
            <div class="card cover-card">

                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x400?text=No+Cover' }}"
                    class="book-cover">

            </div>


            {{-- INFO BUKU --}}
            <div class="card book-info">

                <h2>{{ $book->title }}</h2>

                <div class="meta">
                    <strong>Penulis:</strong> {{ $book->author }}
                </div>

                <div class="meta">
                    <strong>Penerbit:</strong> {{ $book->publisher }}
                </div>

                <div class="meta">
                    <strong>Tahun:</strong> {{ $book->year }}
                </div>

                <div class="meta">
                    <strong>Kategori:</strong>

                    @foreach($book->categories as $category)
                        <span class="badge">{{ $category->name }}</span>
                    @endforeach

                </div>

            </div>


            {{-- DESKRIPSI (DI BAWAH INFO) --}}
            <div class="card">

                <h4>📖 Deskripsi</h4>

                <p>
                    {{ $book->description ?? 'Tidak ada deskripsi.' }}
                </p>

            </div>

        </div>



        {{-- RATING + STOK --}}
        <div class="card" style="margin-bottom:25px">

            @php
                $avgRating = $book->reviews_avg_rating ?? 0;
                $rating = round($avgRating);
            @endphp

            <p>

                <strong>Rating:</strong>

                @if($avgRating > 0)

                    <span class="rating">

                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $rating ? '⭐' : '☆' }}
                        @endfor

                        ({{ number_format($avgRating, 1) }})

                    </span>

                @else

                    Belum ada rating

                @endif

            </p>

            <p>
                <strong>Stok:</strong> {{ $book->stock }}
            </p>

            <div class="action-buttons">

                @if($isBorrowed)

                    <p style="color:#f59e0b; font-weight:600;">
                        📌 Sedang kamu pinjam
                    </p>

                @elseif($book->stock > 0)

                    <form action="{{ route('user.loans.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <button type="submit" class="btn-primary">
                            📚 Pinjam Buku
                        </button>

                    </form>

                @else

                    <p style="color:red">Stok habis</p>

                @endif


                <form action="{{ route('user.koleksi.toggle', $book->id) }}" method="POST">
                    @csrf

                    <button type="submit" class="btn-wishlist {{ in_array($book->id, $wishlistIds) ? 'active' : '' }}">

                        @if(in_array($book->id, $wishlistIds))
                            ❤️ Sudah di Koleksi
                        @else
                            🤍 Tambah ke Koleksi
                        @endif

                    </button>

                </form>

            </div>
        </div>



        {{-- ULASAN --}}
        <div class="card" style="margin-bottom:25px">

            <h4>💬 Ulasan Pembaca</h4>

            @forelse($book->reviews as $review)

                <div class="review-item">

                    <strong>{{ $review->user->name }}</strong>

                    <div class="rating">

                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '⭐' : '☆' }}
                        @endfor

                    </div>

                    <p>{{ $review->comment }}</p>

                </div>

            @empty

                <p>Belum ada ulasan.</p>

            @endforelse

        </div>



        {{-- REKOMENDASI --}}
        @if(isset($recommended) && $recommended->count())

            <div class="card">

                <h4>📚 Buku Rekomendasi</h4>

                <div class="book-grid">

                    @foreach($recommended as $item)

                        <a href="{{ route('user.books.show', $item->id) }}" class="book-card">

                            <img
                                src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/300x400?text=No+Cover' }}">

                            <div class="book-card-body">

                                <div class="book-card-title">
                                    {{ Str::limit($item->title, 25) }}
                                </div>

                                <div class="book-card-author">
                                    {{ $item->author }}
                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        @endif


    </div>

@endsection