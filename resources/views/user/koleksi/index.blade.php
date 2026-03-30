@extends('layouts.user')

@section('title','Koleksi Saya')

@section('content')

<div class="page-title"> Koleksi Saya</div>

@if(session('success'))
<div style="background:#dcfce7;color:#166534;padding:10px;margin-bottom:20px;border-radius:10px;">
{{ session('success') }}
</div>
@endif


<div class="book-grid">

@forelse($koleksi as $item)

<div class="book-card">

<div class="book-wrapper">

@if($item->book && $item->book->category)
<div class="book-category">
{{ $item->book->category->name }}
</div>
@endif


<form
action="{{ route('user.koleksi.destroy',$item->id) }}"
method="POST"
class="remove-form"
>
@csrf
@method('DELETE')

<button
class="remove-btn"
onclick="return confirm('Hapus dari koleksi?')"
>
✖
</button>

</form>


@if($item->book && $item->book->cover)

<img
src="{{ $item->book->cover_url }}"
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
href="{{ route('user.books.show',$item->book->id) }}"
class="detail-btn"
>
Lihat Detail
</a>

</div>

</div>


<div class="book-body">

<p class="book-title">
{{ Str::limit($item->book->title ?? 'Buku tidak ditemukan',35) }}
</p>

<p class="book-author">
{{ $item->book->author ?? '-' }}
</p>

<div class="book-stock">
📦 Stok: {{ $item->book->stock ?? 0 }}
</div>

<form
action="{{ route('user.loans.store') }}"
method="POST"
style="margin-top:10px;"
>
@csrf

<input type="hidden" name="book_id" value="{{ $item->book->id }}">

<button class="btn-pinjam">
Pinjam Buku
</button>

</form>

</div>

</div>

@empty

<p>Belum ada buku di koleksi kamu.</p>

@endforelse

</div>


<style>

/* TITLE */

.page-title{
text-align:center;
font-size:32px;
font-weight:800;
margin-bottom:30px;
color:#0f172a;
}


/* GRID */

.book-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
gap:24px;
}


/* WRAPPER */

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


/* IMAGE */

.book-image{
width:100%;
height:100%;
object-fit:contain;
padding:10px;
}


/* OVERLAY */

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


/* CATEGORY */

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


/* REMOVE BUTTON */

.remove-form{
position:absolute;
top:10px;
right:10px;
z-index:2;
}

.remove-btn{
background:white;
border:none;
width:34px;
height:34px;
border-radius:50%;
font-size:16px;
cursor:pointer;
display:flex;
align-items:center;
justify-content:center;
box-shadow:0 2px 8px rgba(0,0,0,.1);
transition:.25s;
}

.remove-btn:hover{
background:#fee2e2;
color:#dc2626;
transform:scale(1.1);
}


/* BODY */

.book-card{
display:flex;
flex-direction:column;
height:100%;
}

.book-body{
padding:14px;
flex:1;
display:flex;
flex-direction:column;
}

.book-title{
font-size:15px;
font-weight:700;
margin-bottom:3px;
color:#0f172a;

display:-webkit-box;
-webkit-line-clamp:2;
-webkit-box-orient:vertical;
overflow:hidden;

min-height:40px;
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


/* PINJAM BUTTON */

.btn-pinjam{
margin-top:auto;
width:100%;
padding:9px;
border:none;
border-radius:10px;

background:#2563eb;
color:white;

font-weight:600;
font-size:13px;

cursor:pointer;
transition:0.2s;
}

.btn-pinjam:hover{
background:#1d4ed8;
}


</style>

@endsection