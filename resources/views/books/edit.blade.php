@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Edit Buku')

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
    max-width:700px;
}

.card-title{
    font-weight:800;
    font-size:18px;
    color:#0b2a5b;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:16px;
}

.label{
    display:block;
    font-size:13px;
    font-weight:600;
    margin-bottom:6px;
    color:#0b2a5b;
}

.input, .textarea, .select{
    width:100%;
    padding:10px 14px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    font-size:14px;
    transition:.2s;
}

.input:focus,
.textarea:focus,
.select:focus{
    outline:none;
    border-color:#1f6feb;
    box-shadow:0 0 0 3px rgba(31,111,235,.15);
}

.textarea{
    min-height:100px;
    resize:vertical;
}

.btn-primary{
    background:#1f6feb;
    color:#fff;
    padding:10px 18px;
    border-radius:12px;
    border:none;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.btn-primary:hover{
    opacity:.9;
}

.btn-back{
    margin-right:10px;
    text-decoration:none;
    font-size:14px;
    color:#64748b;
}
.small-note{
    font-size:12px;
    color:#64748b;
    margin-top:4px;
}
</style>

<div class="card">

    <div class="card-title"> Edit Buku</div>

    <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="label">Judul Buku</label>
            <input type="text" name="title" class="input"
                value="{{ $book->title }}">
        </div>

        <div class="form-group">
            <label class="label">Penulis</label>
            <input type="text" name="author" class="input"
                value="{{ $book->author }}">
        </div>

        <div class="form-group">
            <label class="label">Penerbit</label>
            <input type="text" name="publisher" class="input"
                value="{{ $book->publisher }}">
        </div>

        <div class="form-group">
            <label class="label">Tahun Terbit</label>
            <input type="number" name="year" class="input"
                value="{{ $book->year }}">
        </div>

        <div class="form-group">
            <label class="label">Deskripsi</label>
            <textarea name="description" class="textarea">{{ $book->description }}</textarea>
        </div>

        <div class="form-group">
            <label class="label">Stok Buku</label>
            <input type="number" name="stock" class="input"
                value="{{ $book->stock }}">
        </div>

        <div class="form-group">
            <label class="label">Kategori</label>

            <div class="checkbox-group">
                @foreach($categories as $category)
                    <label class="checkbox-item">
                        <input type="checkbox" 
                            name="categories[]" 
                            value="{{ $category->id }}"
                            {{ $book->categories->contains($category->id) ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>

            <div class="small-note">
                Pilih satu atau lebih kategori.
            </div>
        </div>

        <div class="form-group">
            <label class="label">Cover Buku</label>

            @if($book->cover)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/'.$book->cover) }}" 
                        width="120"
                        style="border-radius:12px;">
                </div>
            @endif

            <input type="file" name="cover" class="input">

            <div class="small-note">
                Kosongkan jika tidak ingin mengganti cover.
            </div>
        </div>

        <a href="{{ route('books.index') }}" class="btn-back">
            ← Kembali
        </a>

        <button type="submit" class="btn-primary">
            Update
        </button>

    </form>

</div>

@endsection