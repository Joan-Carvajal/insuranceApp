<?php

use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::post('dashboard/download-pdf', [ContractController::class, 'generate'])->name('dashboard.download-pdf');

});

require __DIR__.'/settings.php';
