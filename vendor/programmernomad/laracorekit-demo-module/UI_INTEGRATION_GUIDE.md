# UI Integration Guide

This package provides demo credential banners for your login pages. Choose the integration method that best suits your project.

## Quick Integration

### Frontend Login Page (Livewire/Blade)

Add the banner to your login view:

```blade
<!-- In your login.blade.php -->
<div class="login-container">
    <h1>Login</h1>
    
    {{-- Add demo banner here --}}
    <x-demo-login-banner type="user" />
    
    <!-- Your login form -->
    <form>...</form>
</div>
```

### Filament Admin Login

#### Option 1: Using Blade Component (Simplest)

Copy the stub file to your project:

```bash
cp vendor/programmernomad/laracorekit-demo-module/stubs/filament-login.blade.php \
   resources/views/filament/pages/auth/login.blade.php
```

#### Option 2: Custom Login Page Class

1. Copy the stub file:
```bash
cp vendor/programmernomad/laracorekit-demo-module/stubs/FilamentLogin.php \
   app/Filament/Pages/Auth/Login.php
```

2. Create the view:
```bash
mkdir -p resources/views/filament/pages/auth
cp vendor/programmernomad/laracorekit-demo-module/stubs/filament-login.blade.php \
   resources/views/filament/pages/auth/login.blade.php
```

3. Register in your Panel Provider:
```php
// app/Providers/Filament/AdminPanelProvider.php

public function panel(Panel \$panel): Panel
{
    return \$panel
        // ... other config
        ->login(\App\Filament\Pages\Auth\Login::class)
        // ... rest of config
}
```

## Stub Files Reference

The package includes ready-to-use stub files in endor/programmernomad/laracorekit-demo-module/stubs/:

- **FilamentLogin.php** - Custom Filament login page class
- **filament-login.blade.php** - Filament login view with demo banner

## Banner Component Usage

The <x-demo-login-banner> component accepts a 	ype attribute:

- 	ype="user" - Shows user demo credentials
- 	ype="admin" - Shows admin demo credentials

### Example: Frontend Login

```blade
<!-- modules/Auth/views/livewire/login.blade.php -->
<div>
    <h2>Welcome Back</h2>
    
    <x-demo-login-banner type="user" />
    
    <form wire:submit="login">
        <!-- form fields -->
    </form>
</div>
```

### Example: Custom Auth Page

```blade
<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <x-demo-login-banner type="user" />
    
    <!-- Your login form -->
</x-guest-layout>
```

## Dashboard Widget

The admin dashboard widget is automatically registered. To display it:

```php
// In your AdminPanelProvider.php

public function panel(Panel \$panel): Panel
{
    return \$panel
        // ... other config
        ->widgets([
            \LaraCoreKit\DemoModule\Filament\Widgets\DemoBannerWidget::class,
            // ... other widgets
        ])
}
```

Or add to specific pages:

```php
use LaraCoreKit\DemoModule\Filament\Widgets\DemoBannerWidget;

class Dashboard extends Page
{
    protected function getHeaderWidgets(): array
    {
        return [
            DemoBannerWidget::class,
        ];
    }
}
```

## Customization

### Change Banner Colors

Edit config/demo.php:

```php
'banner' => [
    'show_on_login' => true,
    'show_on_admin' => true,
    'background_color' => 'yellow-50',  // Tailwind color
    'border_color' => 'yellow-500',
    'text_color' => 'yellow-900',
],
```

### Conditional Display

The banner automatically hides when DEMO_MODE=false. You can also add custom conditions:

```blade
@if(config('demo.enabled') && request()->getHost() === 'demo.yoursite.com')
    <x-demo-login-banner type="admin" />
@endif
```

## Windows PowerShell Commands

For Windows users, here are the PowerShell equivalents:

```powershell
# Copy Filament login stub
Copy-Item "vendor\programmernomad\laracorekit-demo-module\stubs\FilamentLogin.php" 
         -Destination "app\Filament\Pages\Auth\Login.php"

# Copy Filament login view
New-Item -Path "resources\views\filament\pages\auth" -ItemType Directory -Force
Copy-Item "vendor\programmernomad\laracorekit-demo-module\stubs\filament-login.blade.php" 
         -Destination "resources\views\filament\pages\auth\login.blade.php"
```

## Troubleshooting

### Banner Not Showing

1. **Check config cache:**
   ```bash
   php artisan config:clear
   php artisan view:clear
   ```

2. **Verify demo mode is enabled:**
   ```bash
   php artisan tinker
   >>> config('demo.enabled')  // Should return true
   ```

3. **Check if component is registered:**
   ```bash
   php artisan view:clear
   # Try viewing the page again
   ```

### Component Not Found Error

Make sure the package is properly installed:

```bash
composer show programmernomad/laracorekit-demo-module
```

If missing, reinstall:

```bash
composer require programmernomad/laracorekit-demo-module
```

### Styling Issues

The banner uses Tailwind CSS classes. Ensure Tailwind is compiling vendor styles:

```js
// tailwind.config.js
export default {
    content: [
        // ... your paths
        './vendor/programmernomad/laracorekit-demo-module/views/**/*.blade.php',
    ],
}
```

Then rebuild:

```bash
npm run build
```
