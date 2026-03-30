<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Models\Loan;

class LandingController extends Controller
{
public function index()
{
    $favorit = Book::withCount('reviews')
        ->orderBy('reviews_count','desc')
        ->take(10)
        ->get();

    $terbaru = Book::latest()->take(10)->get();

    $reviews = Review::with('user','book')
        ->latest()
        ->take(3)
        ->get();

    $totalBuku = Book::count();
    $totalUser = User::count();
    $totalPeminjaman = Loan::count();

    return view('landing', compact(
        'favorit',
        'terbaru',
        'reviews',
        'totalBuku',
        'totalUser',
        'totalPeminjaman'
    ));
}
}