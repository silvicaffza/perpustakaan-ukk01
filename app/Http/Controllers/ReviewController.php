<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user','book'])->latest()->get();
        return view('reviews.index', compact('reviews'));
    }
}