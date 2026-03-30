<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
    use App\Models\Book;
use App\Models\Loan;

class DashboardController extends Controller
{


public function index()
{
    return view('petugas.dashboard', [
        'totalBooks' => Book::count(),
        'totalLoans' => Loan::count(),
        'pendingLoans' => Loan::where('status','pending')->count(),
        'approvedLoans' => Loan::where('status','approved')->count(),
        'borrowedLoans' => Loan::where('status','borrowed')->count(),
        'recentLoans' => Loan::with(['user','book'])->latest()->take(5)->get(),
    ]);
}
}