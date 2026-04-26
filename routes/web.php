<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Houses;
use App\Livewire\Payments;
use App\Livewire\Rentals;
use App\Livewire\Renters;
use App\Livewire\Users;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('login');
// })->name('home');

Route::get('/', Login::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/houses', Houses::class)->name('houses.index');
    Route::get('/payments', Payments::class)->name('payments.index');
    Route::get('/rentals', Rentals::class)->name('rentals.index');
    Route::get('/renters', Renters::class)->name('renters.index');
    Route::get('/users', Users::class)->name('users.index');

});

require __DIR__.'/auth.php';
