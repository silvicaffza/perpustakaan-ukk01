@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Data Buku')

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

.action-btn{
    padding:6px 12px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    margin-right:6px;
}

.edit{
    background:#e6f0ff;
    color:#1557b0;
}

.delete{
    background:#ffe6e6;
    color:#c0392b;
    border:none;
    cursor:pointer;
}

.empty{
    text-align:center;
    padding:20px;
    color:#64748b;
}
</style>

<div class="card">

    <div class="card-header">
        <div class="card-title">📚 Data Buku</div>
        <a href="{{ route('books.create') }}" class="btn-primary">
            + Tambah Buku
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th style="width:250px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <!-- Cover -->
                <td>
                    @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}" 
                            alt="Cover {{ $book->title }}" 
                            style="width:50px; height:70px; object-fit:cover; border-radius:6px;">
                    @else
                        <img src="{{ asset('images/default-cover.png') }}" 
                            alt="Cover default" 
                            style="width:50px; height:70px; object-fit:cover; border-radius:6px;">
                    @endif
                </td>

                <!-- Judul -->
                <td><strong>{{ $book->title }}</strong></td>

                <!-- Penulis -->
                <td>{{ $book->author }}</td>

                <!-- Stok -->
                <td>
                    <span class="stock {{ $book->stock <= 3 ? 'low' : 'good' }}">
                        {{ $book->stock }}
                    </span>
                </td>

                <!-- Kategori -->
                <td>
                    @forelse($book->categories as $cat)
                        <span class="badge">{{ $cat->name }}</span>
                    @empty
                        -
                    @endforelse
                </td>

                <!-- Aksi -->
                <td>
                    <a href="{{ route('books.show',$book->id) }}" class="action-btn edit" style="background:#d1e7ff; color:#0b2a5b;">
                        Detail
                    </a>

                    <a href="{{ route('books.edit',$book->id) }}" class="action-btn edit">
                        Edit
                    </a>

                    <form action="{{ route('books.destroy',$book->id) }}" 
                        method="POST" 
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete"
                            onclick="return confirm('Yakin ingin menghapus buku ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty">
                    Belum ada data buku.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection