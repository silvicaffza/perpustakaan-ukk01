<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    public function buku(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = Book::with('categories');

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ]);
        }

        $books = $query->latest()->get();

        return view('laporan.buku', compact('books','start','end'));
    }


    public function user(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $role = $request->role;

        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ]);
        }

        $users = $query->latest()->get();

        return view('laporan.user', compact('users','start','end','role'));
    }


public function peminjaman(Request $request)
{
    $start = $request->start;
    $end = $request->end;
    $status = $request->status; // 🔥 tambah ini

    $query = Loan::with(['user','book']);

    // FILTER TANGGAL
    if($start){
        $query->whereDate('borrowed_at','>=',$start);
    }

    if($end){
        $query->whereDate('borrowed_at','<=',$end);
    }

    // 🔥 FILTER STATUS
    if($status){
        $query->where('status', $status);
    }

    $loans = $query->latest()->get();

    return view('laporan.peminjaman',[
        'loans'=>$loans,
        'start'=>$start,
        'end'=>$end,
        'status'=>$status // kirim ke view
    ]);
}


    public function pengembalian(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = Loan::with(['user','book'])
                    ->whereNotNull('returned_at');

        if ($start) {
            $query->whereDate('returned_at','>=',$start);
        }

        if ($end) {
            $query->whereDate('returned_at','<=',$end);
        }

        $loans = $query->latest()->get();

        return view('laporan.pengembalian', compact('loans','start','end'));
    }
}