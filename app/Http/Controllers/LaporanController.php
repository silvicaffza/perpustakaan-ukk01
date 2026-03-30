<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    // =========================
    // 📚 LAPORAN BUKU
    // =========================
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

        $query = User::with('loans'); // 🔥 penting

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


    // =========================
    // 📚 LAPORAN PEMINJAMAN AKTIF
    // =========================
    public function peminjaman(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = Loan::with(['user','book'])

            // 🔥 HANYA YANG AKTIF
            ->whereIn('status', ['approved', 'borrowed']);

        // FILTER TANGGAL
        if ($start) {
            $query->whereDate('borrowed_at', '>=', $start);
        }

        if ($end) {
            $query->whereDate('borrowed_at', '<=', $end);
        }

        $loans = $query->latest()->get();

        return view('laporan.peminjaman', [
            'loans' => $loans,
            'start' => $start,
            'end' => $end
        ]);
    }


    // =========================
    // ✅ LAPORAN PENGEMBALIAN
    // =========================
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


    // =========================
    // ❌ LAPORAN PENOLAKAN
    // =========================
    public function laporanPenolakan(Request $request)
    {
        $query = Loan::with(['user','book'])
            ->where('status', 'rejected');

        if ($request->start) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        if ($request->end) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        $loans = $query->latest()->get();

        return view('laporan.penolakan', [
            'loans' => $loans,
            'start' => $request->start,
            'end' => $request->end
        ]);
    }

}