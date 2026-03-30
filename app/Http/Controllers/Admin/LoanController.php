<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user.loans', 'book'])
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->whereNull('returned_at')
            ->latest()
            ->get();

        return view('loans.index', compact('loans'));
    }

    // Tampilkan peminjaman yang sudah dikembalikan
    public function returned()
    {
        $loans = Loan::with(['user', 'book'])
            ->whereNotNull('returned_at')
            ->latest()
            ->get();

        return view('loans.returned', compact('loans'));
    }

    // Approve pinjaman
    public function approve($id)
    {
        $loan = Loan::findOrFail($id);

        // hanya dari pending
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Tidak bisa approve!');
        }

        $loan->update([
            'status' => 'approved',
            'pickup_deadline' => now()->addDays(2)
        ]);

        return back()->with('success', 'Disetujui, tunggu user ambil buku!');
    }

    public function confirmPickup($id)
    {
        $loan = Loan::with('book')->findOrFail($id);

        // hanya dari approved
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Belum bisa diambil!');
        }

        if ($loan->book->stock <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        $loan->update([
            'status' => 'borrowed',
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14)
        ]);

        $loan->book->decrement('stock');

        return back()->with('success', 'Buku sudah diambil!');
    }

    // Reject pinjaman
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Peminjaman ditolak!');
    }

    public function rejected()
    {
        $loans = Loan::where('status', 'rejected')->latest()->get();

        return view('loans.rejected', compact('loans'));
    }

    // Approve pengembalian buku dari user
    public function returnBook(Loan $loan)
    {
        if (!$loan->return_requested_at) {
            return back()->with('error', 'User belum mengajukan pengembalian.');
        }

        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Status tidak valid.');
        }

        $loan->update([
            'status' => 'returned', // 🔥 WAJIB
            'returned_at' => now()
        ]);

        $loan->book->increment('stock');

        return back()->with('success', 'Pengembalian buku berhasil disetujui!');
    }
}