<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 📚 Buku yang sedang dipinjam
        $activeLoans = $user->loans()
            ->where('status','borrowed')
            ->whereNull('returned_at')
            ->count();

        // 🔴 cek buku yang telat
        $lateLoan = $user->loans()
            ->where('status','borrowed')
            ->whereNull('returned_at')
            ->where('due_date','<',now())
            ->exists();

        // 🔴 cek keterlambatan sebelumnya (untuk blokir)
        $lateReturn = $user->loans()
            ->whereNotNull('returned_at')
            ->whereColumn('returned_at','>','due_date')
            ->latest()
            ->first();

        $blockedUntil = null;

        if ($lateReturn) {
            $blockDays = 25;

            $blockedUntil = \Carbon\Carbon::parse($lateReturn->returned_at)
                ->addDays($blockDays);

            if (now()->greaterThan($blockedUntil)) {
                $blockedUntil = null;
            }
        }

        // 📚 Buku terbaru
        $latestBooks = \App\Models\Book::withCount('reviews')
            ->withAvg('reviews','rating')
            ->latest()
            ->take(10)
            ->get();

        // ⭐ Buku favorit
        $favorit = \App\Models\Book::withCount('reviews')
            ->withAvg('reviews','rating')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->take(10)
            ->get();

        // 📂 Kategori
        $categories = \App\Models\Category::withCount('books')->get();

        // ⚙️ Batas pinjam
        $maxLoans = 3;

        $loans = $user->loans()
    ->with('book') // penting biar bisa akses $loan->book->title
    ->latest()
    ->get();

        return view('user.dashboard', compact(
            'activeLoans',
            'maxLoans',
            'latestBooks',
            'categories',
            'favorit',
            'lateLoan',
            'blockedUntil',
            'loans'
        ));
    }
}