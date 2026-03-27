<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Livewire\Login;
use Modules\Auth\Http\Livewire\Register;
use Modules\Auth\Http\Livewire\ForgotPassword;
use Modules\Auth\Http\Livewire\Dashboard;

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return redirect('/super-admin');
        }

        if ($user->hasRole('Warehouse Staff')) {
            return redirect('/warehouse');
        }

        if ($user->hasAnyRole(['Admin', 'Editor'])) {
            return redirect('/admin');
        }

        return view('auth::livewire.dashboard');
    })->name('dashboard');

    Route::get('/profile',
        \Modules\Auth\Http\Livewire\Profile::class
    )->name('profile');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware(['web', 'auth'])->name('logout');
