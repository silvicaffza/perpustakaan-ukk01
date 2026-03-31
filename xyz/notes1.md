# Catatan Halaman Laporan

## Role
- **Admin**: bisa lihat & edit laporan, hapus laporan  
- **Petugas**: hanya bisa lihat laporan

## Fitur khusus admin
- Tombol **Edit** & **Delete**  
- Bisa akses route backend `/laporan/{id}/edit`

## Tips
- Gunakan Blade condition untuk sembunyikan tombol di petugas  
- Proteksi route backend agar aman  

## Contoh Kode Blade

```blade
@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<h1>Laporan</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Detail</th>
    </tr>

    @foreach($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nama }}</td>
            <td>
                <a href="{{ route('laporan.show', $item->id) }}">Lihat</a>
                @if($isAdmin)
                    | <a href="{{ route('laporan.edit', $item->id) }}">Edit</a>
                    | <a href="{{ route('laporan.delete', $item->id) }}">Hapus</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>