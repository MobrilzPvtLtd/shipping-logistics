<?php

namespace Modules\Auth\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Models\User;

#[Layout('core::layouts.app')]
#[Title('Login')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public string $status = '';

    public function login()
    {
        $this->resetErrorBag();
        $this->status = '';

        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Login attempt', ['email' => $this->email]);

        $user = User::where('email', $this->email)->first();

        if (! $user) {
            Log::warning('Login failed - user not found', ['email' => $this->email]);
            $this->addError('email', 'Email does not exist. Please sign up first.');
            return;
        }

        if (! $user->hasVerifiedEmail()) {
            if (app()->environment('local', 'testing')) {
                $user->markEmailAsVerified();
                Log::info('Auto-verifying user in local/testing environment', ['email' => $this->email]);
            } else {
                $user->sendEmailVerificationNotification();
                $this->status = 'Your account is not verified. A new verification link has been sent to your email.';
                Log::info('Login blocked - email not verified', ['email' => $this->email]);
                return;
            }
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            Log::warning('Login failed - invalid credentials', ['email' => $this->email]);
            $this->addError('email', 'The provided credentials do not match our records.');
            return;
        }

        session()->regenerate();
        session()->forget('url.intended');

        Log::info('Login successful', ['email' => $this->email]);
        $successMessage = 'Login successful! Redirecting you now.';

        // Redirect based on role
        if ($user->hasRole('Super Admin')) {
            Log::info('Redirecting to /super-admin');
            return redirect('/super-admin')->with('status', $successMessage);
        }

        if ($user->hasRole('Warehouse Staff')) {
            Log::info('Redirecting to /warehouse');
            return redirect('/warehouse')->with('status', $successMessage);
        }

        if ($user->hasAnyRole(['Admin', 'Editor'])) {
            Log::info('Redirecting to /admin');
            return redirect('/admin')->with('status', $successMessage);
        }

        if (! $user->hasCompletedDetails()) {
            Log::info('Redirecting to user details completion page for incomplete user', ['email' => $this->email]);
            return redirect()->route('user.details.complete')->with('status', 'Please complete your details before continuing.');
        }

        Log::info('Redirecting to /dashboard');
        return redirect('/dashboard')->with('status', $successMessage);
    }

    public function render()
    {
        return view('auth::livewire.login');
    }
}
