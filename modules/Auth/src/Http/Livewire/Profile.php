<?php

namespace Modules\Auth\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('core::layouts.app')]
#[Title('Profile')]
class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $current_password = null;
    public ?string $new_password = null;
    public ?string $new_password_confirmation = null;

    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(): void
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'. $user->id],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->new_password) {
            if (! Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', __('Current password is incorrect.'));

                return;
            }

            $user->password = Hash::make($this->new_password);
            $user->save();
        }

        session()->flash('status', __('Profile updated successfully.'));
    }

    public function render()
    {
        return view('auth::livewire.profile');
    }
}
