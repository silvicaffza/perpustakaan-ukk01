<!DOCTYPE html>
<html>
<head>
    <title>Bukti Peminjaman</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { border: 2px solid #000; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; margin-top: 20px; }
        td { padding: 6px; }
    </style>
</head>
<body>

<h2>BUKTI PEMINJAMAN BUKU</h2>

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
            <td>Status</td>
            <td>: Disetujui</td>
        </tr>
    </table>
</div>

</body>
</html>