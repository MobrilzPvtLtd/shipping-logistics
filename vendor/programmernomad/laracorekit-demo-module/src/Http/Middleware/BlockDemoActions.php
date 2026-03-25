<?php

namespace LaraCoreKit\DemoModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockDemoActions
{
    protected array $blockedRoutes = [
        'filament.admin.resources.users.delete',
        'filament.admin.resources.roles.delete',
        'filament.admin.settings.*',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (! config('demo.enabled')) {
            return $next($request);
        }

        $currentRoute = $request->route()?->getName();

        if ($currentRoute) {
            foreach ($this->blockedRoutes as $pattern) {
                if (fnmatch($pattern, $currentRoute)) {
                    if (class_exists(\Filament\Notifications\Notification::class)) {
                        \Filament\Notifications\Notification::make()
                            ->warning()
                            ->title('Demo Mode')
                            ->body('This action is disabled in demo environment')
                            ->persistent()
                            ->send();
                    }

                    return redirect()->back()->with('error', 'Action disabled in demo mode');
                }
            }
        }

        return $next($request);
    }
}
