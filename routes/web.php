<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;


Route::view('/', 'home')
->middleware(['auth', 'verified'])
->name('home');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);
        // Autres routes d'administration
    });

require __DIR__.'/auth.php';

Route::get('/order/confirmation/{order}', function (Order $order) {
    return view('order.confirmation', compact('order'));
})->name('order.confirmation');
