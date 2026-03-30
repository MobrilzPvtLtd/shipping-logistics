<?php

namespace Modules\Auth\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('core::layouts.app')]
#[Title('Profile')]
class Profile extends Component
{
    use WithFileUploads;

    public string $account_number = '';
    public string $name = '';
    public string $email = '';
    public ?string $address = null;
    public ?string $payment_preference = null;
    public bool $door_to_door = false;
    public ?string $government_id_path = null;
    public ?bool $government_id_uploaded = false;

    public ?\Illuminate\Http\UploadedFile $government_id_file = null;

    public ?string $current_password = null;
    public ?string $new_password = null;
    public ?string $new_password_confirmation = null;
    public bool $show_password = false;

    public array $paymentPreferences = [
        'credit_card' => 'Credit Card',
        'bank_transfer' => 'Bank Transfer',
        'cash_on_delivery' => 'Cash on Delivery',
    ];

    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        if ($user->hasAnyRole(['Super Admin', 'Admin', 'Warehouse Staff'])) {
            abort(403);
        }

        $this->account_number = $user->account_number ?? ('ACC-' . str_pad($user->id, 6, '0', STR_PAD_LEFT));
        $this->name = $user->name;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->payment_preference = $user->payment_preference;
        $this->door_to_door = (bool) $user->door_to_door;
        $this->government_id_path = $user->government_id_path;
        $this->government_id_uploaded = ! empty($user->government_id_path);
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
            'address' => ['nullable', 'string', 'max:1000'],
            'payment_preference' => ['nullable', 'string', 'in:' . implode(',', array_keys($this->paymentPreferences))],
            'door_to_door' => ['boolean'],
            'government_id_file' => ['nullable', 'file', 'max:10240'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
                'payment_preference' => $this->payment_preference,
                'door_to_door' => $this->door_to_door,
                'account_number' => $this->account_number,
            ]);

            if ($this->government_id_file) {
                $path = $this->government_id_file->store('government_ids', 'public');
                $user->government_id_path = $path;
                $user->save();
                $this->government_id_path = $path;
                $this->government_id_uploaded = true;
            }

            if ($this->new_password) {
                if (! Hash::check($this->current_password, $user->password)) {
                    $this->addError('current_password', __('Current password is incorrect.'));

                    return;
                }

                $user->password = Hash::make($this->new_password);
                $user->save();
            }

            session()->flash('status', __('Profile updated successfully.'));
        } catch (\Throwable $e) {
            session()->flash('error', __('Unable to update profile: :message', ['message' => $e->getMessage()]));
        }
    }

    public function render()
    {
        return view('auth::livewire.profile');
    }
}
