@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    max-width:700px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
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

.input, .textarea{
    width:100%;
    padding:10px 14px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    font-size:14px;
    transition:.2s;
}

.input:focus,
.textarea:focus{
    outline:none;
    border-color:#1f6feb;
    box-shadow:0 0 0 3px rgba(31,111,235,.15);
}

.textarea{
    min-height:100px;
    resize:vertical;
}

.checkbox-group{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(150px,1fr));
    gap:8px;
    margin-top:6px;
}

.checkbox-item{
    background:#f8fafc;
    padding:8px 10px;
    border-radius:10px;
    font-size:13px;
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
</style>

<div class="card">

    <div class="card-title">📚 Tambah Buku</div>

    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="label">Judul Buku</label>
            <input type="text" name="title" class="input" placeholder="Masukkan judul buku">
        </div>

        <div class="form-group">
            <label class="label">Penulis</label>
            <input type="text" name="author" class="input" placeholder="Masukkan nama penulis">
        </div>

        <div class="form-group">
            <label class="label">Penerbit</label>
            <input type="text" name="publisher" class="input" placeholder="Masukkan nama penerbit">
        </div>

        <div class="form-group">
            <label class="label">Tahun Terbit</label>
            <input type="number" name="year" class="input" placeholder="Contoh: 2024">
        </div>

        <div class="form-group">
            <label class="label">Stok</label>
            <input type="number" name="stock" class="input" placeholder="Jumlah stok">
        </div>

        <div class="form-group">
            <label class="label">Cover Buku</label>
            <input type="file" name="cover" class="input">
        </div>

        <div class="form-group">
            <label class="label">Deskripsi</label>
            <textarea name="description" class="textarea" placeholder="Deskripsi buku..."></textarea>
        </div>

        <div class="form-group">
            <label class="label">Kategori</label>
            <div class="checkbox-group">
                @foreach($categories as $category)
                    <label class="checkbox-item">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn-primary">
            Simpan Buku
        </button>

    </form>

</div>

@endsection