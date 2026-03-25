<?php

namespace LaraCoreKit\DemoModule\Filament\Widgets;

use Filament\Widgets\Widget;

class DemoBannerWidget extends Widget
{
    protected string $view = 'demo::filament.widgets.demo-banner';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = -100;

    public static function canView(): bool
    {
        return config('demo.enabled', false) && config('demo.banner.show_on_admin', true);
    }

    public function getCredentials(): array
    {
        return config('demo.credentials', [
            'admin' => ['email' => 'admin@demo.test', 'password' => 'Admin@123'],
            'user' => ['email' => 'user@demo.test', 'password' => 'User@123'],
        ]);
    }

    public function getResetInterval(): int
    {
        return config('demo.reset_interval', 30);
    }
}
