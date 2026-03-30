@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<style>
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px,1fr));
    gap: 16px;
    margin-bottom: 18px;
}

.box {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 16px;
    border: 1px solid rgba(255,255,255,0.5);
    box-shadow: 0 8px 20px rgba(0,0,0,.05);
    transition: .25s;
}

.box:hover {
    transform: translateY(-5px) scale(1.01);
}

.box-icon {
    font-size: 20px;
    margin-bottom: 4px;
}

.box-title {
    font-size: 12px;
    color: #64748b;
}

.box-value {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
}

/* WARNA */
.blue { border-left: 4px solid #3b82f6; }
.green { border-left: 4px solid #10b981; }
.orange { border-left: 4px solid #f59e0b; }
.red { border-left: 4px solid #ef4444; }

/* CARD */
.card-soft {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(10px);
    padding: 18px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.6);
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
    margin-top: 16px;
}

.section-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1e293b;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    font-size: 13px;
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

.pending { background:#fff7ed; color:#ea580c; }
.approved { background:#ecfdf5; color:#16a34a; }
.borrowed { background:#e0f2fe; color:#0369a1; }
.returned { background:#dcfce7; color:#166534; }
.rejected { background:#fef2f2; color:#dc2626; }

canvas {
    max-height: 220px;
}
</style>

<h2 style="margin-bottom:12px;">✨ Dashboard Admin</h2>

{{-- 📊 MAIN --}}
<div class="dashboard">

    <div class="box blue">
        <div class="box-icon">👤</div>
        <div class="box-title">Total User</div>
        <div class="box-value">{{ $totalUsers }}</div>
    </div>

    <div class="box green">
        <div class="box-icon">📚</div>
        <div class="box-title">Total Buku</div>
        <div class="box-value">{{ $totalBooks }}</div>
    </div>

    <div class="box orange">
        <div class="box-icon">📖</div>
        <div class="box-title">Total Peminjaman</div>
        <div class="box-value">{{ $totalLoans }}</div>
    </div>

</div>

{{-- 🔥 STATUS --}}
<div class="dashboard">

    <div class="box orange">
        <div class="box-title">⏳ Pending</div>
        <div class="box-value">{{ $pendingLoans }}</div>
    </div>

    <div class="box green">
        <div class="box-title">✅ Disetujui</div>
        <div class="box-value">{{ $approvedLoans }}</div>
    </div>

    <div class="box blue">
        <div class="box-title">📖 Dipinjam</div>
        <div class="box-value">{{ $borrowedLoans }}</div>
    </div>

    <div class="box green">
        <div class="box-title">🔄 Dikembalikan</div>
        <div class="box-value">{{ $returnedLoans }}</div>
    </div>

    <div class="box red">
        <div class="box-title">❌ Ditolak</div>
        <div class="box-value">{{ $rejectedLoans }}</div>
    </div>

</div>

{{-- 📈 CHART --}}
<div class="card-soft">
    <div class="section-title">📈 Grafik Peminjaman</div>
    <canvas id="loanChart"></canvas>
</div>

{{-- 📌 RECENT --}}
<div class="card-soft">
    <div class="section-title">📌 Aktivitas Terbaru</div>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($recentLoans as $loan)
            <tr>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->book->title }}</td>
                <td>
                    <span class="badge {{ $loan->status }}">
                        {{ ucfirst($loan->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Belum ada aktivitas</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- 📊 CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('loanChart').getContext('2d');

const gradient = ctx.createLinearGradient(0,0,0,200);
gradient.addColorStop(0, "rgba(99,102,241,0.4)");
gradient.addColorStop(1, "rgba(99,102,241,0)");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Peminjaman',
            data: @json($chartData),
            borderColor: '#6366f1',
            backgroundColor: gradient,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { grid: { display:false } },
            y: { grid: { color:'#eee' } }
        }
    }
});
</script>

@endsection