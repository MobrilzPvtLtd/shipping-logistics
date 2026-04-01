<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Modules\User\Models\User;
use Modules\Auth\Http\Livewire\Login;
use Modules\Auth\Http\Livewire\Register;
use Modules\Auth\Http\Livewire\ForgotPassword;
use Modules\Auth\Http\Livewire\ResetPassword;
use Modules\Auth\Http\Livewire\Dashboard;

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware(['web'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth::livewire.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
        if (! URL::hasValidSignature($request)) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/dashboard')->with('status', 'Your email is already verified.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        Auth::login($user);
        session()->regenerate();

        return redirect('/dashboard')->with('status', 'Your email has been verified and you are now logged in.');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()) {
            $user = $request->user();
        } else {
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            if (! $user) {
                return back()->withErrors(['email' => 'User not found for this email.']);
            }
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('status', 'Email is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->name('verification.send');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('verified');
    Route::get('/profile', \Modules\Auth\Http\Livewire\Profile::class)->name('profile');

    Route::get('/shipments', [\App\Http\Controllers\ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/create', [\App\Http\Controllers\ShipmentController::class, 'create'])->name('shipments.create');
    Route::post('/shipments', [\App\Http\Controllers\ShipmentController::class, 'store'])->name('shipments.store');
    Route::get('/shipments/{shipment}/edit', [\App\Http\Controllers\ShipmentController::class, 'edit'])->name('shipments.edit');
    Route::put('/shipments/{shipment}', [\App\Http\Controllers\ShipmentController::class, 'update'])->name('shipments.update');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware(['web', 'auth'])->name('logout');
