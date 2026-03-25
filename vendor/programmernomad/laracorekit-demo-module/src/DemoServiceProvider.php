<?php

namespace LaraCoreKit\DemoModule;

use Filament\Facades\Filament;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use LaraCoreKit\DemoModule\Console\Commands\ResetDemoDatabase;
use LaraCoreKit\DemoModule\Filament\Widgets\DemoBannerWidget;
use LaraCoreKit\DemoModule\Http\Middleware\BlockDemoActions;
use LaraCoreKit\DemoModule\Http\Middleware\DemoModeMiddleware;

class DemoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/demo.php', 'demo');
    }

    public function boot(): void
    {
        if (! config('demo.enabled')) {
            return;
        }

        $this->validateDemoHost();

        $this->loadViewsFrom(__DIR__.'/../views', 'demo');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ResetDemoDatabase::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/demo.php' => config_path('demo.php'),
            ], 'demo-config');
        }

        $router = $this->app['router'];
        $router->aliasMiddleware('demo', DemoModeMiddleware::class);
        $router->aliasMiddleware('demo.block', BlockDemoActions::class);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('demo:reset --force')
                ->cron('*/'.config('demo.reset_interval').' * * * *')
                ->withoutOverlapping()
                ->runInBackground()
                ->onFailure(fn () => \Log::error('Demo reset failed'));

            // Auto-register Filament render hook for admin login banner
            $this->registerFilamentRenderHook();
        });

        Gate::before(function ($user, $ability) {
            if (in_array($ability, config('demo.blocked_actions', []))) {
                return false;
            }
        });

        Blade::component('demo::components.login-banner', 'demo-login-banner');
    }

    protected function registerFilamentRenderHook(): void
    {
        if (! class_exists(Filament::class)) {
            return;
        }

        try {
            Filament::registerRenderHook(
                'panels::auth.login.form.before',
                fn () => new HtmlString('
                    <div class="rounded-lg bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-yellow-800">
                                    Demo Mode Active
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p><strong>Admin:</strong> <span class="font-mono">' . config('demo.credentials.admin.email') . ' / ' . config('demo.credentials.admin.password') . '</span></p>
                                    <p class="mt-1 text-xs text-yellow-600">Database auto-resets every ' . config('demo.reset_interval') . ' minutes. Changes won\'t persist.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ')
            );
        } catch (\Exception $e) {
            // Silently fail if Filament is not properly configured
        }
    }

    protected function validateDemoHost(): void
    {
        if ($this->app->environment('production')) {
            $host = request()->getHost();
            if (! in_array($host, config('demo.allowed_hosts', []))) {
                abort(403, 'Demo mode not allowed on this domain');
            }
        }
    }
}
