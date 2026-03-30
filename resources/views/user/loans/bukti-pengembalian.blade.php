<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pengembalian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { border: 2px solid #000; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; margin-top: 20px; }
        td { padding: 6px; }
    </style>
</head>
<body>

<h2>BUKTI PENGEMBALIAN BUKU</h2>

<div class="container">
    <table>
        <tr>
            <td>Nama Peminjam</td>
            <td>: {{ $loan->user->name }}</td>
        </tr>
        <tr>
            <td>Judul Buku</td>
            <td>: {{ $loan->book->title }}</td>
        </tr>
        <tr>
            <td>Tanggal Pinjam</td>
            <td>: {{ $loan->borrowed_at }}</td>
        </tr>
        <tr>
            <td>Jatuh Tempo</td>
            <td>: {{ $loan->due_date }}</td>
        </tr>
        <tr>
            <td>Tanggal Pengembalian Disetujui</td>
            <td>: {{ $loan->returned_at }}</td>
        </tr>

        @php
            $isLate = $loan->returned_at > $loan->due_date;
            $lateDays = $isLate 
                ? $loan->due_date->startOfDay()->diffInDays($loan->returned_at->startOfDay())
                : 0;
        @endphp

        <tr>
            <td>Status</td>
            <td>
                :
                @if($isLate)
                    Terlambat {{ $lateDays }} hari
                @else
                    Tepat Waktu
                @endif
            </td>
        </tr>
    </table>
</div>

</body>
</html>