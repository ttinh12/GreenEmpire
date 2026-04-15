<?php

use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\TicketController;

use Illuminate\Support\Facades\Auth;

use App\Models\User;



Route::get('/', function () {

    return redirect()->route('login');

});

use App\Models\Ticket;



Route::get('/dashboard', function () {

    $tickets = Ticket::where('user_id', Auth::id())->paginate(10);

    return view('dashboard', compact('tickets'));

})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/services', [HomeController::class, 'service'])
    ->middleware(['auth'])
    ->name('services.index');

Route::get('/tickets', [TicketController::class, 'index'])

    ->middleware(['auth'])

    ->name('tickets.index');

Route::get('/tickets/create', [TicketController::class, 'create'])

    ->middleware(['auth'])

    ->name('ticket.create');

Route::get('/tickets/{id}', [TicketController::class, 'show'])

    ->middleware(['auth'])

    ->name('tickets.show');
Route::get('/services/{id}', [HomeController::class, 'serviceDetail'])->name('services.show');


Route::post('/tickets/store', [TicketController::class, 'store'])

    ->middleware(['auth'])

    ->name('ticket.store');



Route::middleware('auth')->group(function () {

    Route::get('/profile', [HomeController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [HomeController::class, 'update'])->name('profile.update');

    // Route::delete('/profile', [HomeController::class, 'destroy'])->name('profile.destroy');

    Route::put('/profile/password', [HomeController::class, 'updatePassword'])->name('profile.password.update');

});
// Chỉ Admin mới vào được nhóm này
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/custom-stats', function () {
        return "Trang thống kê nội bộ của Admin";
    });
    // Thêm các route admin khác ở đây...
});



require __DIR__ . '/auth.php';

