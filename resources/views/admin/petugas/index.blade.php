@extends('layouts.admin')

@section('page_title','Data Petugas')

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
}

.badge{
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:#e6f0ff;
    color:#1557b0;
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
</style>

<div class="card">

    <div class="card-header">
        <div class="card-title">👩‍💼 Data Petugas</div>
        <a href="{{ route('petugas.create') }}" class="btn-primary">
            + Tambah Petugas
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:250px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $p)
            <tr>
                <td>
                    <strong>{{ $p->name }}</strong><br>
                    <span class="badge">Petugas</span>
                </td>
                <td>{{ $p->email }}</td>
                <td>
                    <a href="{{ route('petugas.edit',$p->id) }}" class="action-btn edit">
                        Edit
                    </a>
                    <form action="{{ route('petugas.destroy',$p->id) }}" 
                          method="POST" 
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete">
                            Hapus
                        </button>
                    </form>
                </td>
                
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; padding:20px;">
                    Belum ada data petugas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection