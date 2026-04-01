@extends('layouts.admin')

@section('page_title','Detail Petugas')

@section('content')

<style>
.card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    max-width:520px;
    box-shadow:0 10px 26px rgba(14,60,120,.08);
}

.card-title{
    font-weight:800;
    font-size:18px;
    color:#0b2a5b;
    margin-bottom:20px;
}

.detail-group{
    margin-bottom:16px;
}

.label{
    font-size:13px;
    font-weight:600;
    color:#64748b;
    margin-bottom:4px;
}

.value{
    font-size:15px;
    font-weight:600;
    color:#0b2a5b;
}

.badge{
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:#e6f0ff;
    color:#1557b0;
}

.btn-back{
    display:inline-block;
    margin-top:18px;
    text-decoration:none;
    font-size:14px;
    color:#1f6feb;
    font-weight:600;
}
</style>

<div class="card">

    <div class="card-title"> Detail Petugas</div>

    <div class="detail-group">
        <div class="label">Nama</div>
        <div class="value">{{ $petugas->name }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Email</div>
        <div class="value">{{ $petugas->email }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Role</div>
        <div class="value">
            <span class="badge">{{ ucfirst($petugas->role) }}</span>
        </div>
    </div>

    <a href="{{ route('petugas.index') }}" class="btn-back">
        ← Kembali ke Data Petugas
    </a>

</div>

@endsection