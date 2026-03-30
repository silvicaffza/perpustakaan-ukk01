@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Daftar Peminjaman')

@section('content')

<style>
.card {
    background: #fff;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 10px 26px rgba(14, 60, 120, .08);
}

.card-title {
    font-weight: 800;
    font-size: 18px;
    color: #0b2a5b;
    margin-bottom: 18px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table thead {
    background: #f4f8ff;
}

.table th {
    text-align: left;
    padding: 12px;
    font-weight: 700;
    color: #0b2a5b;
}

.table td {
    padding: 12px;
    border-top: 1px solid rgba(21, 87, 176, .08);
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* warna tetap pakai class status */
.pending { background: #fff4e6; color: #e67e22; }
.approved { background: #e6f0ff; color: #1d4ed8; }
.borrowed { background: #e6f9f0; color: #1e7e34; }
.rejected { background: #ffe6e6; color: #c0392b; }
.returned { background: #e8f8ff; color: #0c8599; }

.action-btn {
    padding: 6px 12px;
    border-radius: 10px;
    border: none;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.btn-approve {
    background: #e6f9f0;
    color: #1e7e34;
}

.btn-reject {
    background: #ffe6e6;
    color: #c0392b;
}

.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    margin: 120px auto;
}

.modal textarea {
    width: 100%;
    height: 90px;
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 8px;
}
</style>

<div class="card">

    <div class="card-title">📖 Daftar Peminjaman Buku</div>

    @php
        $statusText = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'borrowed' => 'Sedang Dipinjam',
            'returned' => 'Sudah Dikembalikan',
            'rejected' => 'Ditolak',
        ];
    @endphp

    <table class="table">
        <thead>
            <tr>
                <th>Nama Pengguna</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Permintaan Pengembalian</th>
                <th>Aksi</th>
                <th>Pinjaman Aktif</th>
            </tr>
        </thead>

        <tbody>
            @forelse($loans as $loan)

                @php
                    $activeLoans = $loan->user->loans
                        ->whereIn('status', ['pending','approved','borrowed'])
                        ->whereNull('returned_at')
                        ->count();
                @endphp

                <tr>
                    <td><strong>{{ $loan->user->name }}</strong></td>
                    <td>{{ $loan->book->title }}</td>

                    <td>
                        <span class="badge {{ $loan->status }}">
                            {{ $statusText[$loan->status] ?? $loan->status }}
                        </span>
                    </td>

                    <td>
                        @if($loan->return_requested_at && !$loan->returned_at)
                            ⏳ Menunggu Persetujuan
                        @elseif($loan->returned_at)
                            ✅ Selesai
                        @else
                            -
                        @endif
                    </td>

                    <td>

                        {{-- MENUNGGU --}}
                        @if($loan->status == 'pending')

                            <form action="{{ route('loans.approve', $loan->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="action-btn btn-approve">Setujui</button>
                            </form>

                            <button onclick="openRejectModal({{ $loan->id }})" class="action-btn btn-reject">
                                Tolak
                            </button>

                        @endif

                        {{-- DISETUJUI --}}
                        @if($loan->status == 'approved')

                            <form action="{{ route('loans.pickup', $loan->id) }}" method="POST">
                                @csrf
                                <button class="action-btn btn-approve">
                                    Konfirmasi Pengambilan
                                </button>
                            </form>

                        @endif

                        {{-- PENGEMBALIAN --}}
                        @if($loan->return_requested_at && !$loan->returned_at)
                            <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                                @csrf
                                <button class="action-btn btn-approve">
                                    Setujui Pengembalian
                                </button>
                            </form>
                        @endif

                    </td>

                    <td>
                        @if($activeLoans >= 3)
                            <span style="color:red; font-weight:700;">
                                {{ $activeLoans }} / 3 ⚠️
                            </span>
                        @else
                            <span style="color:green; font-weight:600;">
                                {{ $activeLoans }} / 3
                            </span>
                        @endif
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        Belum ada data peminjaman
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- MODAL --}}
<div id="rejectModal" class="modal">
    <div class="modal-content">

        <h3>Tolak Peminjaman</h3>

        <form id="rejectForm" method="POST">
            @csrf

            <textarea name="rejection_reason"
                placeholder="Masukkan alasan penolakan..." required></textarea>

            <div style="margin-top:10px;">
                <button type="submit" class="action-btn btn-reject">
                    Kirim
                </button>

                <button type="button" onclick="closeModal()" class="action-btn">
                    Batal
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openRejectModal(id) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');

    form.action = `/loans/${id}/reject`;
    modal.style.display = 'block';
}

function closeModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>

@endsection