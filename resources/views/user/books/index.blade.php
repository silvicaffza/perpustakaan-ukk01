@extends('layouts.user')

@section('title','Daftar Buku')

@section('content')

<div class="page-title">Katalog Buku</div>

<!-- FILTER BAR -->

<div class="filter-bar">

<form method="GET" action="{{ route('user.books.index') }}">

<div class="search-box">

<span class="search-icon">🔍</span>

<input
type="text"
name="search"
placeholder="Cari judul atau penulis buku..."
value="{{ request('search') }}"
class="search-input"
>

</div>

<div class="filter-row">

<div class="category-chips">

@foreach($categories as $category)

<label class="chip">

<input
type="checkbox"
name="category[]"
value="{{ $category->id }}"
{{ in_array($category->id, request('category', [])) ? 'checked' : '' }}
>

<span>
{{ $category->name }} ({{ $category->books_count }})
</span>

</label>

@endforeach

</div>

<div class="sort-box">

<label>Urutkan</label>

<select name="sort" class="category-select">
<option value="">Terbaru</option>
<option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
Rating Tertinggi
</option>
</select>

</div>

<button class="btn-search">
Cari
</button>

<a href="{{ route('user.books.index') }}" class="btn-reset">
Reset
</a>

</div>

</form>

@if(request('search'))
<p style="margin-bottom:15px;color:#64748b;">
Menampilkan hasil untuk "<b>{{ request('search') }}</b>"
</p>
@endif

</div>

<!-- BOOK GRID -->

<div class="book-grid">

@forelse($books as $book)

<div class="book-card">

<div class="book-wrapper">

@if($book->category)
<div class="book-category">
{{ $book->category->name }}
</div>
@endif


<form
action="{{ route('user.koleksi.toggle',$book->id) }}"
method="POST"
class="wishlist-form"
>
@csrf

<button class="wishlist-btn">
<span class="heart">
{{ in_array($book->id,$wishlistIds ?? []) ? '❤️' : '🤍' }}
</span>
</button>

</form>


@if($book->cover)

<img
src="{{ $book->cover_url }}"
class="book-image"
>

@else

<img
src="https://via.placeholder.com/300x400?text=No+Cover"
class="book-image"
>

@endif


<div class="book-overlay">

<a
href="{{ route('user.books.show',$book->id) }}"
class="detail-btn"
>
Lihat Detail
</a>

</div>

</div>


<div class="book-body">

<p class="book-title">
{{ Str::limit($book->title,35) }}
</p>

<p class="book-author">
{{ $book->author }}
</p>

<div class="book-stock">
📦 Stok: {{ $book->stock }}
</div>

@php
$avg = $book->reviews_avg_rating ?? 0;
$rating = round($avg);
@endphp

<div class="rating">

@for($i=1;$i<=5;$i++)
{{ $i <= $rating ? '⭐' : '☆' }}
@endfor

<span class="rating-text">

{{ number_format($avg,1) }}

•

{{ $book->reviews_count }}

ulasan

</span>

</div>

</div>

</div>

@empty

<p>Tidak ada buku ditemukan.</p>

@endforelse

</div>
<div class="pagination-wrapper">
{{ $books->links() }}
</div>


<style>
/* ================= FILTER ================= */
.page-title{
text-align:center;
font-size:32px;
font-weight:800;
margin-bottom:30px;
color:#0f172a;
letter-spacing:1px;
}
.category-select{
appearance:none;
-webkit-appearance:none;
-moz-appearance:none;

background:#f8fafc;
border:1px solid #e2e8f0;

padding:10px 38px 10px 14px;
border-radius:12px;

font-size:14px;
font-weight:500;
color:#334155;

cursor:pointer;

background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6' stroke='%2364748b' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");

background-repeat:no-repeat;
background-position:right 12px center;

transition:0.25s;
}

.category-select:hover{
border-color:#1f6feb;
background:#ffffff;
}

.category-select:focus{
outline:none;
border-color:#1f6feb;
box-shadow:0 0 0 3px rgba(31,111,235,.15);
}

.filter-bar{
margin-bottom:35px;
}

.sort-box{
display:flex;
align-items:center;
gap:8px;
}

.sort-box label{
font-size:13px;
color:#64748b;
}
.search-box{
position:relative;
margin-bottom:15px;
}

.search-icon{
position:absolute;
left:14px;
top:50%;
transform:translateY(-50%);
font-size:15px;
color:#94a3b8;
}

.search-input{
width:100%;
padding:14px 16px 14px 40px;
border-radius:14px;
border:1px solid #e2e8f0;
font-size:15px;
background:#f8fafc;
transition:.25s;
}

.search-input:focus{
outline:none;
background:white;
border-color:#1f6feb;
box-shadow:0 0 0 4px rgba(31,111,235,.12);
}

.filter-row{
display:flex;
gap:10px;
flex-wrap:wrap;
align-items:center;
}

.category-chips{
display:flex;
flex-wrap:wrap;
gap:10px;
margin-bottom:12px;
}

.chip{
cursor:pointer;
}

.chip input{
display:none;
}

.chip span{
display:inline-block;
padding:8px 16px;
border-radius:25px;
font-size:13px;
font-weight:500;
color:#1e293b;
background:linear-gradient(135deg,#e0f2fe,#f1f5f9);
border:1px solid #cbd5f5;
transition:.25s;
}

.chip span:hover{
transform:translateY(-2px);
box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.chip input:checked + span{
background:linear-gradient(135deg,#1f6feb,#2563eb);
color:white;
border:none;
box-shadow:0 4px 10px rgba(37,99,235,.4);
}

.chip input:checked + span{
background:#1f6feb;
color:white;
border-color:#1f6feb;
}

.btn-search{
background:#1f6feb;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
font-weight:600;
}

.btn-reset{
background:#f1f5f9;
padding:10px 14px;
border-radius:10px;
font-size:13px;
text-decoration:none;
color:#334155;
}


/* ================= BOOK GRID ================= */

.book-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
gap:24px;
}


/* ================= BOOK CARD ================= */

.book-wrapper{
position:relative;
aspect-ratio:3/4;
border-radius:16px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
background:#f8fafc;
display:flex;
align-items:center;
justify-content:center;
}

.book-wrapper:hover{
transform:translateY(-6px);
}


/* ================= COVER ================= */

.book-image{
width:100%;
height:100%;
object-fit:contain;
padding:10px;
}

/* ================= OVERLAY ================= */

.book-overlay{
position:absolute;
inset:0;
background:rgba(0,0,0,.55);
display:flex;
align-items:center;
justify-content:center;
opacity:0;
transition:.3s;
}

.book-wrapper:hover .book-overlay{
opacity:1;
}

.detail-btn{
background:#D6C8BA;
color:#052659;
padding:8px 18px;
border-radius:20px;
font-size:13px;
font-weight:700;
text-decoration:none;
}

.detail-btn:hover{
background:white;
}


/* ================= CATEGORY BADGE ================= */

.book-category{
position:absolute;
top:10px;
left:10px;
background:#1f6feb;
color:white;
font-size:11px;
padding:5px 10px;
border-radius:20px;
font-weight:600;
z-index:2;
}


/* ================= WISHLIST ================= */

.wishlist-form{
position:absolute;
top:10px;
right:10px;
z-index:2;
}

.wishlist-btn{
background:white;
border:none;
width:36px;
height:36px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
font-size:16px;
box-shadow:0 2px 8px rgba(0,0,0,.1);
transition:.25s;
}

.wishlist-btn:hover{
transform:scale(1.1);
background:#ffe4e6;
}


/* ================= BODY ================= */

.book-body{
padding:14px;
}

.book-title{
font-size:15px;
font-weight:700;
margin-bottom:3px;
color:#0f172a;
}

.book-author{
font-size:13px;
color:#64748b;
}

.book-stock{
font-size:12px;
color:#64748b;
margin-top:3px;
}

.rating{
font-size:12px;
color:#f59e0b;
margin-top:6px;
}

.rating-text{
color:#64748b;
font-size:11px;
margin-left:4px;
}


/* ================= PAGINATION ================= */

.pagination-wrapper{
margin-top:40px;
display:flex;
justify-content:center;
}

/* FILTER BAR */

.filter-bar{
background:white;
padding:20px;
border-radius:16px;
box-shadow:0 8px 20px rgba(0,0,0,.05);
margin-bottom:35px;
}

.search-box{
position:relative;
margin-bottom:15px;
}

.search-icon{
position:absolute;
left:14px;
top:50%;
transform:translateY(-50%);
font-size:15px;
color:#94a3b8;
}

.search-input{
width:100%;
padding:14px 16px 14px 40px;
border-radius:14px;
border:1px solid #e2e8f0;
font-size:15px;
background:#f8fafc;
transition:0.25s;
}

.search-input:focus{
outline:none;
background:white;
border-color:#1f6feb;
box-shadow:0 0 0 4px rgba(31,111,235,.12);
}

.filter-row{
display:flex;
gap:10px;
flex-wrap:wrap;
align-items:center;
}

.category-chips{
display:flex;
flex-wrap:wrap;
gap:10px;
margin-bottom:12px;
}

.chip{
cursor:pointer;
}

.chip input{
display:none;
}

.chip span{
display:inline-block;
padding:8px 14px;
border-radius:20px;
border:1px solid #e2e8f0;
font-size:13px;
color:#334155;
background:#f8fafc;
transition:0.2s;
}

.chip input:checked + span{
background:#1f6feb;
color:white;
border-color:#1f6feb;
}

.btn-search{
background:#1f6feb;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
font-weight:600;
}

.btn-reset{
background:#f1f5f9;
padding:10px 14px;
border-radius:10px;
font-size:13px;
text-decoration:none;
color:#334155;
}


/* BOOK GRID */
.book-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
gap:24px;
}

.book-wrapper{
position:relative;
aspect-ratio:3/4;
border-radius:15px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
background:#f8fafc;
display:flex;
align-items:center;
justify-content:center;
}

.book-wrapper:hover{
transform:translateY(-8px);
}

.book-image{
width:100%;
height:100%;
object-fit:contain;
}

.book-overlay{
position:absolute;
inset:0;
background:rgba(0,0,0,.55);
display:flex;
align-items:center;
justify-content:center;
opacity:0;
transition:.3s;
}

.book-wrapper:hover .book-overlay{
opacity:1;
}

.detail-btn{
background:#D6C8BA;
color:#052659;
padding:8px 18px;
border-radius:20px;
font-size:13px;
font-weight:700;
text-decoration:none;
}

.detail-btn:hover{
background:white;
}

.book-author{
font-size:12px;
color:#666;
}

/* COVER */



/* CATEGORY BADGE */

.book-category{
position:absolute;
top:10px;
left:10px;
background:#1f6feb;
color:white;
font-size:11px;
padding:5px 10px;
border-radius:20px;
font-weight:600;
z-index:2;
}


/* WISHLIST */

.wishlist-form{
position:absolute;
top:10px;
right:10px;
z-index:2;
}

.wishlist-btn.active{
background:#ef4444;
color:white;
}

.wishlist-btn{
background:white;
border:none;
width:36px;
height:36px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
font-size:16px;
box-shadow:0 2px 8px rgba(0,0,0,.1);
transition:0.25s;
}

.wishlist-btn:hover{
transform:scale(1.1);
background:#ffe4e6;
}


/* HOVER DETAIL */

.hover-detail{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.55);
display:flex;
align-items:center;
justify-content:center;
opacity:0;
backdrop-filter:blur(2px);
transition:0.35s;
}

.book-card:hover .hover-detail{
opacity:1;
}

.btn-hover-detail{
background:white;
color:#1f6feb;
padding:10px 18px;
border-radius:20px;
font-size:13px;
font-weight:600;
text-decoration:none;
}


/* BODY */

.book-body{
padding:15px;
}

.book-title{
font-size:15px;
font-weight:700;
margin-bottom:4px;
color:#0f172a;
}

.book-meta{
font-size:13px;
color:#64748b;
}

.book-stock{
font-size:12px;
color:#64748b;
margin-top:2px;
}

.rating{
font-size:12px;
color:#f59e0b;
margin-top:6px;
}

.rating-text{
color:#64748b;
font-size:11px;
margin-left:4px;
}

.pagination-wrapper{
margin-top:40px;
display:flex;
justify-content:center;
}

</style>


<script>
document.querySelectorAll('.category-chips input').forEach(function(el){
    el.addEventListener('change', function(){
        this.closest('form').submit();
    });
});
</script>

@endsection