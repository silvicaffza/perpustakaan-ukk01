@php
    $isAdmin = request()->is('admin/*');
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title','Tambah User')

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
    max-width:520px;
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

.input{
    width:100%;
    padding:10px 14px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    font-size:14px;
    transition:.2s;
}

.input:focus{
    outline:none;
    border-color:#1f6feb;
    box-shadow:0 0 0 3px rgba(31,111,235,.15);
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
</style>

<div class="card">

    <div class="card-title"> Tambah User</div>

    <form action="{{ route('account-user.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="label">Nama</label>
            <input 
                type="text" 
                name="name" 
                class="input"
                placeholder="Masukkan nama user">
        </div>

        <div class="form-group">
            <label class="label">Email</label>
            <input 
                type="email" 
                name="email" 
                class="input"
                placeholder="Masukkan email user">
        </div>

        <div class="form-group">
            <label class="label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="input"
                placeholder="Masukkan password">
        </div>

        <a href="{{ route('account-user.index') }}" class="btn-back">
            ← Kembali
        </a>

        <button type="submit" class="btn-primary">
            Simpan
        </button>

    </form>

</div>

@endsection