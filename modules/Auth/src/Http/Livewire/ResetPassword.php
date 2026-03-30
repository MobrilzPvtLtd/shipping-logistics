<?php

namespace Modules\Auth\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

#[Layout('core::layouts.app')]
#[Title('Reset Password')]
class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $message = '';

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $data = $this->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            $this->message = __('Your password has been reset. You can now login.');
            return redirect()->route('login')->with('status', __($status));
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('auth::livewire.reset-password');
    }
}
