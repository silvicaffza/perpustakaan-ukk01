@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('content')

<h3>Riwayat Penolakan</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>User</th>
        <th>Buku</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Alasan</th>
    </tr>

    @foreach($loans as $loan)
    <tr>
        <td>{{ $loan->user->name }}</td>
        <td>{{ $loan->book->title }}</td>
        <td>{{ $loan->created_at }}</td>
        <td style="color:red;">Ditolak</td>
        <td>{{ $loan->rejection_reason }}</td>
    </tr>
    @endforeach
</table>

@endsection