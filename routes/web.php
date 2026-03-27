<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;




Route::prefix('ticket')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('ticket.index');
        Route::get('/create', 'create')->name('ticket.create');
        Route::post('/create', 'store')->name('ticket.store');
        Route::get('/edit/{id}', 'edit')->name('ticket.edit');
        Route::post('/update/{id}', 'update')->name('ticket.update');
        Route::post('/close/{id}', 'close')->name('ticket.close');
    });
});
