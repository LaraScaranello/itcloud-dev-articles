<?php

use App\Livewire\Developers;
use Illuminate\Support\Facades\Route;

Route::view('/', 'livewire.auth.login')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/developers', Developers\Index::class)->name('developers');
});

require __DIR__.'/settings.php';
