<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\TicketController;




Route::prefix('ticket')->group(function () {
    Route::controller(TicketController::class)->group(function () {
        Route::get('/', 'index')->name('ticket.home');
        Route::get('/create', 'create')->name('ticket.create');
        Route::post('/create', 'store')->name('ticket.store');
        Route::get('/edit/{id}', 'edit')->name('ticket.edit');
        Route::post('/update/{id}', 'update')->name('ticket.update');
        Route::post('/close/{id}', 'close')->name('ticket.close');
    });
});
Route::prefix('/')->group(function () {
    Route::controller(App\Http\Controllers\client\HomeController::class)->group(function () {
        Route::get('/', 'index')->name('client.home');
        Route::get('/dashboard', 'dashboard')->name('client.dashboard');
        Route::get('/profile', 'profile')->name('client.profile');
        Route::get('/setting', 'setting')->name('client.setting');
        Route::get('/logout', 'logout')->name('client.logout');
    });
});
