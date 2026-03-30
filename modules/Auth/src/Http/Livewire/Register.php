<?php

namespace Modules\Auth\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('core::layouts.app')]
#[Title('Register')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $status = '';
    public bool $submitting = false;

    public function register()
    {
        $this->submitting = true;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->sendEmailVerificationNotification();

        $this->status = 'Registration successful! Verification email sent to ' . $this->email;

        // logout first to allow redirect to login for unverified user path
        Auth::logout();

        return redirect()->route('login')->with('status', 'Registration successful! Please check your email and verify within 5 minutes.');
    }

    public function render()
    {
        return view('auth::livewire.register');
    }
}
