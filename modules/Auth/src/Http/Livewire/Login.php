<?php

namespace Modules\Auth\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Login attempt', ['email' => $this->email]);

        $user = \Modules\User\Models\User::where('email', $this->email)->first();

        if (! $user) {
            $this->addError('email', 'Email does not exist. Please sign up first.');
            return;
        }

        if (! Hash::check($this->password, $user->password)) {
            $this->addError('password', 'Invalid password. Please try again.');
            return;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            $this->status = 'Your account is not verified. A new verification link has been sent to your email.';
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            session()->forget('url.intended');

            Log::info('Login successful', [
                'email' => $this->email,
            ]);

            // Redirect based on role
            if ($user->hasRole('Super Admin')) {
                Log::info('Redirecting to /super-admin');
                return redirect('/super-admin');
            }

            if ($user->hasRole('Warehouse Staff')) {
                Log::info('Redirecting to /warehouse');
                return redirect('/warehouse');
            }

            if ($user->hasAnyRole(['Admin', 'Editor'])) {
                Log::info('Redirecting to /admin');
                return redirect('/admin');
            }

            Log::info('Redirecting to /dashboard');
            return redirect('/dashboard');
        }

        Log::warning('Login failed.', ['email' => $this->email]);
        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('auth::livewire.login');
    }
}
