<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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

class WarehousePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('warehouse')
            ->path('warehouse')
            ->login()
            ->authGuard('web')
            ->brandName('LaraCoreKit - Warehouse')
            ->brandLogo($this->resolveBrandLogo())
            ->darkMode(true)
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Red,
            ])
            ->font('Inter')
            ->resources([
                \Modules\Blog\Filament\Resources\BlogResource::class,
                \App\Filament\Resources\ShipmentResource::class,
                \App\Filament\Resources\PackageResource::class,
                \App\Filament\Resources\InvoiceResource::class,
            ])
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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

            return asset($logo);
        }

        return asset('images/logo.jpeg');
    }
}
