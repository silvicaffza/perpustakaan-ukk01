<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    // 📚 Pinjaman aktif
    public function index()
    {
        $loans = auth()->user()->loans()
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->whereNull('returned_at')
            ->whereNull('return_requested_at') // 🔥 INI KUNCINYA
            ->latest()
            ->get();

        return view('user.loans.index', compact('loans'));
    }

    // 🔄 Menunggu konfirmasi return
    public function returns()
    {
        $loans = auth()->user()->loans()
            ->whereNotNull('return_requested_at')
            ->where('status', 'borrowed')
            ->latest()
            ->get();

        return view('user.loans.returns', compact('loans'));
    }

    // 📜 Riwayat
    public function history()
    {
        $loans = auth()->user()->loans()
            ->with([
                'book',
                'book.reviews' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->where(function ($q) {
                $q->where('status', 'returned')
                    ->orWhere('status', 'rejected');
            })
            ->latest()
            ->get();

        return view('user.loans.history', compact('loans'));
    }

    // ✅ Ajukan pinjaman
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($request->book_id);

        // 🔴 CEK: ada buku telat
        $lateActiveLoan = $user->loans()
            ->whereNull('returned_at')
            ->where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->exists();

        if ($lateActiveLoan) {
            return back()->with('error', 'Masih ada buku terlambat.');
        }

        // 🔴 CEK: masa blokir
        $lateLoan = $user->loans()
            ->whereNotNull('returned_at')
            ->where('status', 'borrowed')
            ->whereColumn('returned_at', '>', 'due_date')
            ->latest()
            ->first();

        if ($lateLoan) {
            $blockUntil = \Carbon\Carbon::parse($lateLoan->returned_at)->addDays(25);

            if (now()->lessThan($blockUntil)) {
                return back()->with('error', 'Diblokir sampai ' . $blockUntil->format('d M Y'));
            }
        }

        // 🔴 CEK: stok
        if ($book->stock <= 0) {
            return back()->with('error', 'Buku tidak tersedia.');
        }

        // 🔴 CEK: sudah pinjam
        $alreadyBorrowed = $user->loans()
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Sudah meminjam buku ini.');
        }

        // 🔴 CEK: maksimal 3
        $activeLoans = $user->loans()
            ->whereNull('returned_at')
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->count();

        if ($activeLoans >= 3) {
            return back()->with('error', 'Maksimal 3 buku!');
        }

        // ✅ simpan
        $user->loans()->create([
            'book_id' => $request->book_id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Permintaan terkirim!');
    }

    // 🔄 Ajukan pengembalian
    public function returnBook($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Belum bisa return.');
        }

        $loan->update([
            'return_requested_at' => now()
        ]);

        return back()->with('success', 'Pengembalian diajukan!');
    }

    // 📄 PDF peminjaman (SEKARANG DI APPROVED)
    public function downloadPdf($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);

        if (!in_array($loan->status, ['approved', 'borrowed'])) {
            return back()->with('error', 'Bukti belum tersedia.');
        }

        $pdf = Pdf::loadView('user.loans.bukti-peminjaman', compact('loan'));

        return $pdf->download('bukti-peminjaman-' . $loan->id . '.pdf');
    }

    // 📄 PDF pengembalian
    public function downloadReturnPdf($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);

        if ($loan->status !== 'returned') {
            return back()->with('error', 'Bukti belum tersedia.');
        }

        $pdf = Pdf::loadView('user.loans.bukti-pengembalian', compact('loan'));

        return $pdf->download('bukti-pengembalian-' . $loan->id . '.pdf');
    }
}