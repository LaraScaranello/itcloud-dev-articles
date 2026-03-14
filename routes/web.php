<?php

use App\Livewire\Developers;
use App\Livewire\Articles;
use Illuminate\Support\Facades\Route;

Route::view('/', 'livewire.auth.login')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/developers', Developers\Index::class)->name('developers');
    Route::get('/articles', Articles\Index::class)->name('articles');
});

require __DIR__.'/settings.php';
