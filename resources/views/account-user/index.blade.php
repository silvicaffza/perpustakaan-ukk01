@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.petugas';
@endphp

@extends($layout)

@section('page_title', 'Data User')

@section('content')

    <style>
        .card {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 10px 26px rgba(14, 60, 120, .08);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-title {
            font-weight: 800;
            font-size: 18px;
            color: #0b2a5b;
        }

        .btn-primary {
            background: #1f6feb;
            color: #fff;
            padding: 8px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            opacity: .9;
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
            background: #e6f0ff;
            color: #1557b0;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-right: 6px;
        }

        .edit {
            background: #e6f0ff;
            color: #1557b0;
        }

        .delete {
            background: #ffe6e6;
            color: #c0392b;
            border: none;
            cursor: pointer;
        }
    </style>

    <div class="card">

        <div class="card-header">
            <div class="card-title">👤 Data User</div>
            <!-- tombol tambah dihapus -->
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th style="width:100px;">Aksi</th>
                    <th>Total Pinjam</th>
                    <th>Terlambat</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong><br>
                            <span class="badge">User</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form action="{{ route('account-user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    Hapus
                                </button>
                            </form>

                        </td>

                        <td>
                            <span class="badge">
                                {{ $user->total_loans }}x
                            </span>
                        </td>

                        <td>
                            @if($user->late_loans > 0)
                                <span class="badge" style="background:#ffe6e6;color:#c0392b;">
                                    {{ $user->late_loans }}x
                                </span>
                            @else
                                <span class="badge" style="background:#e6f9f0;color:#16a34a;">
                                    0
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center; padding:20px;">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection