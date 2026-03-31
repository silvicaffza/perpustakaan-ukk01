<!DOCTYPE html>
<html>
<head>
    <title>Bukti Peminjaman</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { border: 2px solid #000; padding: 20px; margin: 20px auto; width: 450px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 6px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
        .status-approved { color: #1e7e34; font-weight: bold; }
        .status-late { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>

<h2>BUKTI PEMINJAMAN BUKU</h2>

<div class="container">
    <table>
        <tr>
            <td class="label">Nama Peminjam</td>
            <td>: {{ $loan->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Judul Buku</td>
            <td>: {{ $loan->book->title }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pengajuan Pinjam</td>
            <td>: {{ $loan->created_at ? $loan->created_at->format('d-m-Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Batas Pengambilan Buku</td>
            <td>: {{ $loan->pickup_deadline ? $loan->pickup_deadline->format('d-m-Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Batas Peminjaman</td>
            <td>: 20 Hari </td>
            <!-- <td>: {{ $loan->due_date ? $loan->due_date->format('d-m-Y') : '-' }}</td> -->
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>
                @php
                    $now = now();
                    $isLate = $loan->pickup_deadline && $loan->pickup_deadline < $now;
                @endphp

                @if($isLate)
                    <span class="status-late">⚠️ Melewati Batas Pickup</span>
                @else
                    <span class="status-approved">✅ Disetujui</span>
                @endif
            </td>
        </tr>
    </table>
</div>

</body>
</html>