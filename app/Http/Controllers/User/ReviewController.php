<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Loan;
use App\Models\Book;

class ReviewController extends Controller
{
public function store(Request $request, $book_id)
{
    $user = auth()->user();

    // ✅ hanya boleh review kalau sudah returned
    $loan = \App\Models\Loan::where('user_id', $user->id)
        ->where('book_id', $book_id)
        ->where('status', 'returned')
        ->exists();

    if (!$loan) {
        return back()->with('error', 'Anda belum bisa memberi ulasan!');
    }

    // 🚨 cegah double review
    $alreadyReviewed = \App\Models\Review::where('user_id', $user->id)
        ->where('book_id', $book_id)
        ->exists();

    if ($alreadyReviewed) {
        return back()->with('error', 'Anda sudah memberi ulasan untuk buku ini!');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    Review::create([
        'user_id' => $user->id,
        'book_id' => $book_id,
        'rating' => $request->rating,
        'comment' => $request->comment
    ]);

    return back()->with('success', 'Ulasan berhasil dikirim!');
}
public function edit(Review $review)
{
    return view('user.reviews.edit', compact('review'));
}

public function update(Request $request, Review $review)
{
    $request->validate([
        'rating'=>'required|integer|min:1|max:5',
        'comment'=>'nullable|string'
    ]);

    $review->update([
        'rating'=>$request->rating,
        'comment'=>$request->comment
    ]);

    return redirect()->route('user.loans.history')
        ->with('success','Ulasan berhasil diperbarui');
}
}


