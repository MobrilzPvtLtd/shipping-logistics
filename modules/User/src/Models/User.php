<?php

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Modules\User\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'payment_preference',
        'door_to_door',
        'government_id_path',
        'account_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'door_to_door' => 'boolean',
        ];
    }

    /**
     * Determine if user can access a Filament panel by panel id.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        $panelId = $panel->getId();

        return match ($panelId) {
            'super-admin' => $this->hasRole(['Super Admin', 'Admin', 'Warehouse Staff']),
            'admin' => $this->hasAnyRole(['Super Admin', 'Admin', 'Warehouse Staff']),
            'warehouse' => $this->hasRole(['Super Admin', 'Admin', 'Warehouse Staff']),
            default => false,
        };
    }
}
