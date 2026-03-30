<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\LaporanController;
use App\Models\Book;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/


Route::get('/', [LandingController::class,'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PETUGAS
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [App\Http\Controllers\Petugas\DashboardController::class, 'index'])
        ->name('petugas.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('admin.dashboard');
    // CRUD Petugas
    Route::resource('petugas', PetugasController::class);
});


/*
|--------------------------------------------------------------------------
| ADMIN & PETUGAS ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin,petugas')->group(function () {
    Route::get('/account-user', [UserManagementController::class, 'index'])->name('account-user.index');
    Route::get('/account-user/{id}show', [UserManagementController::class, 'show'])->name('account-user.show');
    Route::get('/account-user/create', [UserManagementController::class, 'create'])->name('account-user.create');
    Route::post('/account-user', [UserManagementController::class, 'store'])->name('account-user.store');
    Route::get('/account-user/{id}/edit', [UserManagementController::class, 'edit'])->name('account-user.edit');
    Route::put('/account-user/{id}', [UserManagementController::class, 'update'])->name('account-user.update');
    Route::delete('/account-user/{id}', [UserManagementController::class, 'destroy'])->name('account-user.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    Route::get('/loans', [\App\Http\Controllers\Admin\LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans/{id}/approve', [\App\Http\Controllers\Admin\LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{id}/reject', [\App\Http\Controllers\Admin\LoanController::class, 'reject'])->name('loans.reject');
    Route::get('/loans/returned', [\App\Http\Controllers\Admin\LoanController::class, 'returned'])->name('loans.returned');
    Route::post('/loans/{loan}/return', [\App\Http\Controllers\Admin\LoanController::class,'returnBook'])->name('loans.return');
    Route::get('/loans/rejected', [\App\Http\Controllers\Admin\LoanController::class, 'rejected'])->name('loans.rejected');
    Route::post('/loans/{id}/pickup', [\App\Http\Controllers\Admin\LoanController::class, 'confirmPickup'])->name('loans.pickup');
    Route::get('/reviews', [\App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');

    Route::get('/laporan/buku', [LaporanController::class,'buku'])->name('laporan.buku');
    Route::get('/laporan/user', [LaporanController::class,'user'])->name('laporan.user');
    Route::get('/laporan/peminjaman', [LaporanController::class,'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class,'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/penolakan', [LaporanController::class, 'laporanPenolakan'])
    ->name('laporan.penolakan');

});


/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class,'index'])
        ->name('dashboard');

    // 📚 Peminjaman
    Route::get('/loans', [App\Http\Controllers\User\LoanController::class,'index'])
        ->name('loans.index');

    Route::post('/loans', [App\Http\Controllers\User\LoanController::class,'store'])
        ->name('loans.store');

    Route::post('/loans/{loan}/return', [App\Http\Controllers\User\LoanController::class,'returnBook'])
        ->name('loans.return');

    // 🔄 Pengembalian
    Route::get('/loans/returns', [App\Http\Controllers\User\LoanController::class,'returns'])
        ->name('loans.returns');

    // 📖 Riwayat
    Route::get('/loans/history', [App\Http\Controllers\User\LoanController::class,'history'])
        ->name('loans.history');

    // 📄 PDF
    Route::get('/loan/{id}/pdf', [App\Http\Controllers\User\LoanController::class,'downloadPdf'])
        ->name('loan.pdf');

    Route::get('/loan/{id}/return-pdf', [App\Http\Controllers\User\LoanController::class,'downloadReturnPdf'])
        ->name('loan.return.pdf');

    // 📚 Buku
    Route::get('/books', [App\Http\Controllers\User\BookController::class,'index'])
        ->name('books.index');

    Route::get('/books/{id}', [App\Http\Controllers\User\BookController::class,'show'])
        ->name('books.show');

    // ⭐ Review
    Route::post('/reviews/{book_id}', [App\Http\Controllers\User\ReviewController::class,'store'])
        ->name('reviews.store');

    Route::get('/reviews/{review}/edit', [App\Http\Controllers\User\ReviewController::class,'edit'])
        ->name('reviews.edit');

    Route::put('/reviews/{review}', [App\Http\Controllers\User\ReviewController::class,'update'])
        ->name('reviews.update');

    // ❤️ Koleksi
    Route::post('/koleksi/{book_id}', [KoleksiController::class,'store'])
        ->name('koleksi.store');

    Route::get('/koleksi', [KoleksiController::class,'index'])
        ->name('koleksi.index');

    Route::delete('/koleksi/{id}', [KoleksiController::class,'destroy'])
        ->name('koleksi.destroy');

    Route::post('/koleksi/{book}/toggle', [KoleksiController::class,'toggle'])
        ->name('koleksi.toggle');

});

