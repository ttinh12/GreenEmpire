<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\TicketController;
use App\Http\Controllers\ContractPdfController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── Trang chủ → redirect login ─────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── Dashboard ──────────────────────────────────────────────────
Route::get('/dashboard', function () {
    $tickets = Ticket::where('user_id', Auth::id())->paginate(10);
    return view('dashboard', compact('tickets'));
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Dịch vụ (public xem, auth để đăng ký) ─────────────────────
Route::get('/services', [ServiceController::class, 'index'])
    ->middleware('auth')
    ->name('services.index');

Route::get('/services/{id}', [ServiceController::class, 'show'])
    ->middleware('auth')
    ->name('services.show');

// ── Luồng đăng ký dịch vụ → hợp đồng → hóa đơn → thanh toán ──
Route::middleware('auth')->prefix('client')->name('client.')->group(function () {

    // Đăng ký dịch vụ
    Route::get('/services/{id}/register', [ServiceController::class, 'register'])
        ->name('services.register');
    Route::post('/services/{id}/register', [ServiceController::class, 'store'])
        ->name('services.store');

    // Hợp đồng
    Route::get('/contracts', [ServiceController::class, 'myContracts'])
        ->name('contracts.index');
    Route::get('/contracts/{id}', [ServiceController::class, 'showContract'])
        ->name('contracts.show');
    Route::post('/contracts/{id}/sign', [ServiceController::class, 'signContract'])
        ->name('contracts.sign');

    // Hóa đơn
    Route::get('/invoices', [ServiceController::class, 'myInvoices'])
        ->name('invoices.index');
    Route::get('/invoices/{id}', [ServiceController::class, 'showInvoice'])
        ->name('invoices.show');
    Route::post('/invoices/{id}/pay', [ServiceController::class, 'payInvoice'])
        ->name('invoices.pay');
});

// ── Ticket ─────────────────────────────────────────────────────
Route::get('/tickets', [TicketController::class, 'index'])->middleware('auth')->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->middleware('auth')->name('ticket.create');
Route::post('/tickets/store', [TicketController::class, 'store'])->middleware('auth')->name('ticket.store');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->middleware('auth')->name('tickets.show');

// ── Profile ────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [HomeController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [HomeController::class, 'update'])->name('profile.update');
    Route::get('/profile', [HomeController::class, 'show'])->name('profile.show');
    Route::put('/profile/password', [HomeController::class, 'updatePassword'])->name('profile.password.update');
});

// ── PDF Hợp đồng ───────────────────────────────────────────────
Route::get('/admin/contracts/{id}/view-pdf', [ContractPdfController::class, 'download'])
    ->middleware('auth')
    ->name('contracts.pdf');

require __DIR__ . '/auth.php';