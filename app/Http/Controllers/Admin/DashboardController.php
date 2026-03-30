<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Grafik per bulan
        $monthlyLoans = Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $data[] = $monthlyLoans[$i] ?? 0;
        }

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalBooks' => Book::count(),
            'totalLoans' => Loan::count(),

            // 🔥 STATUS
            'pendingLoans' => Loan::where('status', 'pending')->count(),
            'approvedLoans' => Loan::where('status', 'approved')->count(),
            'borrowedLoans' => Loan::where('status', 'borrowed')->count(),
            'returnedLoans' => Loan::where('status', 'returned')->count(),
            'rejectedLoans' => Loan::where('status', 'rejected')->count(),

            // 📌 Recent
            'recentLoans' => Loan::with('user', 'book')->latest()->take(5)->get(),

            // 📈 Chart
            'chartLabels' => $labels,
            'chartData' => $data
        ]);
    }
}