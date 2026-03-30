<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Category;

class BookController extends Controller
{

    public function index(Request $request)
    {

        $query = Book::query()
            ->withAvg('reviews','rating')
            ->withCount('reviews');

        /* =====================
           SEARCH
        ===================== */

        if ($request->search) {

            $query->where(function($q) use ($request){

                $q->where('title','like','%'.$request->search.'%')
                  ->orWhere('author','like','%'.$request->search.'%');

            });

        }


        /* =====================
           FILTER CATEGORY
        ===================== */

        if ($request->filled('category')) {

            $query->whereHas('categories', function($q) use ($request){

                $q->whereIn('categories.id', $request->category);

            });

        }


        /* =====================
           SORT
        ===================== */

        if ($request->sort == 'rating') {

            $query->orderByDesc('reviews_avg_rating');

        } else {

            $query->latest();

        }


        /* =====================
           PAGINATION
        ===================== */

        $books = $query
            ->paginate(12)
            ->withQueryString();


        $categories = Category::withCount('books')->get();

        $wishlistIds = auth()->check()
            ? auth()->user()->koleksi()->pluck('book_id')->toArray()
            : [];

        return view(
            'user.books.index',
            compact('books','categories', 'wishlistIds')
        );
    }

public function show($id)
{
    $book = Book::with([
        'reviews' => function($q){
            $q->latest()->take(3); // 🔥 3 ulasan terbaru
        },
        'reviews.user',
        'categories'
    ])
        ->withAvg('reviews','rating')
        ->withCount('reviews')
        ->findOrFail($id);

    $recommended = Book::whereHas('categories', function($q) use ($book) {
            $q->whereIn('categories.id', $book->categories->pluck('id'));
        })
        ->where('id','!=',$book->id)
        ->take(4)
        ->get();

    $wishlistIds = auth()->check()
        ? auth()->user()->koleksi()->pluck('book_id')->toArray()
        : [];
        
    $isBorrowed = false;

    if (auth()->check()) {
        $isBorrowed = Loan::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereNull('returned_at') // belum dikembalikan
            ->exists();
    }

    return view(
        'user.books.show',
        compact('book','recommended','wishlistIds','isBorrowed')
    );
}
}