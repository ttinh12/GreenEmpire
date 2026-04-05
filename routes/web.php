<?php



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

Route::get('/tickets/create', [TicketController::class, 'create'])

    ->middleware(['auth'])

    ->name('ticket.create');



Route::post('/tickets/store', [TicketController::class, 'store'])

    ->middleware(['auth'])

    ->name('ticket.store');



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__ . '/auth.php';

