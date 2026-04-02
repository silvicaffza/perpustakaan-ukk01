@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')

    <div class="page-title">
        Riwayat Peminjaman
    </div>

    <div class="loan-nav">

        <a href="{{ route('user.loans.index') }}"
            class="loan-tab {{ request()->routeIs('user.loans.index') ? 'active' : '' }}">
             Dipinjam
        </a>

        <a href="{{ route('user.loans.returns') }}"
            class="loan-tab {{ request()->routeIs('user.loans.returns') ? 'active' : '' }}">
             Pengembalian
        </a>

        <a href="{{ route('user.loans.history') }}"
            class="loan-tab {{ request()->routeIs('user.loans.history') ? 'active' : '' }}">
             Riwayat
        </a>

    </div>

    <div class="book-grid">

        @forelse($loans as $loan)

            @php
                $review = $loan->book->reviews->first();
            @endphp

            <div class="book-card">

                <div class="book-wrapper">
                    @if($loan->book->cover)
                        <img src="{{ asset('storage/' . $loan->book->cover) }}" class="book-image">
                    @else
                        <img src="https://via.placeholder.com/300x400?text=No+Cover" class="book-image">
                    @endif
                </div>

                <div class="book-body">

                    <p class="book-title">
                        {{ Str::limit($loan->book->title ?? '-', 35) }}
                    </p>

                    {{-- STATUS REJECT --}}
                    @if($loan->status == 'rejected')
                        <div class="status-reject">
                            ❌ Peminjaman Ditolak
                        </div>

                        <div class="reject-reason">
                            {{ $loan->rejection_reason ?? 'Tidak ada alasan' }}
                        </div>
                    @endif

                    {{-- ACTION --}}
                    <div class="loan-actions">

                        {{-- 📄 Bukti Pinjam --}}
                        @if($loan->status !== 'rejected')
                            <a href="{{ route('user.loan.pdf', $loan->id) }}" class="loan-btn loan-btn-secondary">
                                Bukti Pinjam
                            </a>
                        @endif

                        {{-- 📄 Bukti Pengembalian --}}
                        @if($loan->status == 'returned')
                            <a href="{{ route('user.loan.return.pdf', $loan->id) }}" class="loan-btn loan-btn-success">
                                Bukti Kembali
                            </a>
                        @endif

                    </div>

                    {{-- REVIEW --}}
                    @if($loan->returned_at)

                        <div class="review-box">

                            @if(!$review)

                                <form action="{{ route('user.reviews.store', $loan->book->id) }}" method="POST">
                                    @csrf

                                    <div class="rating-input">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $loan->id }}-{{ $i }}" name="rating" value="{{ $i }}" required>
                                            <label for="star{{ $loan->id }}-{{ $i }}">★</label>
                                        @endfor
                                    </div>

                                    <input type="text" name="comment" placeholder="Tulis ulasan...">

                                    <button type="submit" class="loan-btn loan-btn-primary">
                                        Kirim
                                    </button>

                                </form>

                            @else

                                <div class="rating-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span class="star filled">★</span>
                                        @else
                                            <span class="star">★</span>
                                        @endif
                                    @endfor
                                </div>

                                <div class="review-text">
                                    "{{ $review->comment }}"
                                </div>

                                <button onclick="openModal(
                                    '{{ route('user.reviews.update', $review->id) }}',
                                    '{{ $review->rating }}',
                                    `{{ $review->comment }}`
                                )" class="loan-btn loan-btn-primary">
                                    Edit Review
                                </button>

                            @endif

                        </div>

                    @endif

                </div>

            </div>
<div id="reviewModal" class="modal">
    <div class="modal-content">

        <h3>Edit Review</h3>

        <form id="reviewForm" method="POST">
            @csrf
            @method('PUT')

            <div class="rating-input">
                @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="modal-star{{ $i }}" name="rating" value="{{ $i }}">
                    <label for="modal-star{{ $i }}">★</label>
                @endfor
            </div>

            <input type="text" id="modalComment" name="comment" placeholder="Edit ulasan...">

            <div style="margin-top:10px; display:flex; gap:10px;">
                <button type="submit" class="loan-btn loan-btn-primary">
                    Update
                </button>

                <button type="button" onclick="closeModal()" class="loan-btn loan-btn-secondary">
                    Batal
                </button>
            </div>

        </form>

    </div>
</div>
        @empty

            <div class="empty-text">
                Belum ada riwayat peminjaman.
            </div>

        @endforelse

    </div>


    <style>
        /* TITLE */
        .page-title {
            text-align: center;
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 30px;
            color: #0f172a;
        }

        /* NAV */
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
        }

        .loan-tab.active {
            background: #1f6feb;
            color: white;
        }

        /* GRID */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
        }

        /* CARD */
        .book-wrapper {
            aspect-ratio: 3/4;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .book-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }

        .book-body {
            padding: 14px;
        }

        .book-title {
            font-weight: 700;
        }

        /* BUTTON */
        .loan-btn {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .loan-btn-secondary {
            background: #64748b;
            color: #fff;
        }

        .loan-btn-success {
            background: #16a34a;
            color: #fff;
        }

        .loan-btn-primary {
            background: #1f6feb;
            color: #fff;
        }

        /* ⭐ INPUT */
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
        }

        .rating-input label:hover,
        .rating-input label:hover~label {
            color: #f59e0b;
        }

        .rating-input input:checked~label {
            color: #f59e0b;
        }

        /* ⭐ DISPLAY */
        .star {
            color: #ccc;
        }

        .star.filled {
            color: #f59e0b;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 320px;
        }

        .empty-text {
            text-align: center;
            margin-top: 40px;
        }

        .status-reject {
            background: #ffe6e6;
            color: #c0392b;
            padding: 6px;
            border-radius: 8px;
            margin-bottom: 6px;
        }
    </style>

    <script>
        function openModal(action, rating, comment) {
    document.getElementById('reviewModal').style.display = 'flex'
    document.getElementById('reviewForm').action = action
    document.getElementById('modalComment').value = comment

    // set rating
    const stars = document.querySelectorAll('#reviewModal input[name="rating"]')
    stars.forEach(star => {
        if (star.value == rating) {
            star.checked = true
        }
    })
}

        function closeModal() {
            document.getElementById('reviewModal').style.display = 'none'
        }
    </script>

@endsection