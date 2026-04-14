<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\ShipmentWidget;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\Models\Setting;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web')
            ->brandName('LaraCoreKit - Admin')
            ->brandLogo($this->resolveBrandLogo())
            ->darkMode(true)
            ->renderHook('panels::topbar.end', fn() => view('filament.dark-mode-toggle'))
            ->renderHook('panels::body.end', fn() => view('filament.login-placeholders'))
            ->colors([
                'primary' => Color::Red,
                'danger' => Color::Red,
            ])
            ->font('Inter')
            ->resources([
                \Modules\Blog\Filament\Resources\BlogResource::class,
                \Modules\Shipment\Filament\Resources\ShipmentResource::class,
                \Modules\User\Filament\Resources\UserResource::class,
                \Modules\User\Filament\Resources\Roles\RoleResource::class,
                \Modules\User\Filament\Resources\Permissions\PermissionResource::class,
            ])
            ->pages([
                \App\Filament\Pages\Dashboard::class,
                \Modules\Settings\Filament\Pages\Settings::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                // ShipmentWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\EnsureFilamentPanelRole::class,
            ]);
    }

    private function resolveBrandLogo(): string
    {
        $logo = Setting::get('site_logo');

        if (!empty($logo)) {
            if (filter_var($logo, FILTER_VALIDATE_URL)) {
                return $logo;
            }

            if (Storage::disk('public')->exists($logo)) {
                return asset("storage/{$logo}");
            }

            // If file path is already a storage URL or relative path, attempt direct URL
            return asset($logo);
        }

        return asset('images/logo.jpeg');
    }
}
