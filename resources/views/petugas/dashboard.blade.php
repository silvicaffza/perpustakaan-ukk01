@extends('layouts.petugas')

@section('content')
    <h3>Selamat datang, {{ auth()->user()->name }}</h3>
@endsection