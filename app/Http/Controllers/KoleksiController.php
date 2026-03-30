<?php

namespace App\Http\Controllers;

use App\Models\KoleksiRbadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    public function store($book_id)
    {
        $user = Auth::user();

        // Cek apakah sudah ada
        $exists = KoleksiRbadi::where('user_id', $user->id)
                    ->where('book_id', $book_id)
                    ->exists();

        if (!$exists) {
            KoleksiRbadi::create([
                'user_id' => $user->id,
                'book_id' => $book_id
            ]);
        }

        return back()->with('success', 'Buku ditambahkan ke koleksi!');
    }

    public function index()
    {
        $koleksi = KoleksiRbadi::with('book')
                    ->where('user_id', Auth::id())
                    ->get();

        return view('user.koleksi.index', compact('koleksi'));
    }

    public function destroy($id)
    {
        $koleksi = KoleksiRbadi::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $koleksi->delete();

        return back()->with('success', 'Buku dihapus dari koleksi.');
    }

public function toggle($bookId)
{
    $user = auth()->user();

    $exists = KoleksiRbadi::where('user_id',$user->id)
                ->where('book_id',$bookId)
                ->first();

    if($exists){
        $exists->delete();
    }else{
        KoleksiRbadi::create([
            'user_id'=>$user->id,
            'book_id'=>$bookId
        ]);
    }

    return back();
}
}