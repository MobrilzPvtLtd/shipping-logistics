# LaraCoreKit Demo Module

Auto-resetting demo environment for Laravel applications with Filament integration. Perfect for showcasing your Laravel projects with automatic database resets every 30 minutes.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/programmernomad/laracorekit-demo-module.svg?style=flat-square)](https://packagist.org/packages/programmernomad/laracorekit-demo-module)
[![Total Downloads](https://img.shields.io/packagist/dt/programmernomad/laracorekit-demo-module.svg?style=flat-square)](https://packagist.org/packages/programmernomad/laracorekit-demo-module)
[![License](https://img.shields.io/packagist/l/programmernomad/laracorekit-demo-module.svg?style=flat-square)](https://packagist.org/packages/programmernomad/laracorekit-demo-module)

## Features

- ✅ **Auto-Reset Database**: Automatically fresh migrate + seed every 30 minutes (configurable)
- ✅ **Demo Credentials Banner**: Show login credentials on auth pages and admin dashboard
- ✅ **Filament Integration**: Beautiful admin widgets displaying demo info
- ✅ **Action Blocking**: Prevent destructive operations (user deletion, critical settings)
- ✅ **Media Cleanup**: Auto-delete uploaded files on reset
- ✅ **Session & Cache Clear**: Clean state on every reset
- ✅ **Security**: Domain whitelisting, production safeguards
- ✅ **Cron Scheduling**: Integrated with Laravel scheduler
- ✅ **Customizable**: Full control over reset interval, credentials, blocked actions

## Use Cases

- 🎭 **Demo Websites**: Show off your Laravel/Filament projects
- 🧪 **Testing Environments**: Auto-reset sandbox for testers
- 🎓 **Training Platforms**: Clean state for each training session
- 🚀 **SaaS Trials**: Let users try your app without permanent changes

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or 12.0
- Filament 3.0 (optional, for admin widgets)

## Installation

Install via Composer:

```bash
composer require programmernomad/laracorekit-demo-module
```

The package will automatically register via Laravel's package auto-discovery.

## Configuration

### Step 1: Publish Configuration

```bash
php artisan vendor:publish --tag=demo-config
```

This creates `config/demo.php` with all available options.

### Step 2: Update `.env`

Add these variables to your `.env` file:

```env
# Demo Mode Configuration
DEMO_MODE=true
DEMO_RESET_INTERVAL=30

# Demo Credentials (shown on login pages)
DEMO_ADMIN_EMAIL=admin@demo.test
DEMO_ADMIN_PASSWORD=Admin@123
DEMO_USER_EMAIL=user@demo.test
DEMO_USER_PASSWORD=User@123
```

### Step 3: Setup Cron Job

The module uses Laravel's task scheduler. Add this to your server's crontab:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

**For Plesk Control Panel:**
1. Go to **Scheduled Tasks (Cron Jobs)**
2. Add new task with command:
```bash
cd /var/www/vhosts/yourdomain.com && php artisan schedule:run >> /dev/null 2>&1
```
3. Run: Every minute

## Usage

### Enable Demo Mode

Simply set in your `.env`:

```env
DEMO_MODE=true
```

The module will:
- Show demo credentials on login pages
- Display admin dashboard banner with credentials
- Block destructive actions
- Auto-reset database every 30 minutes

### Manual Database Reset

Force an immediate reset:

```bash
php artisan demo:reset
```

With confirmation prompt:

```bash
php artisan demo:reset --force
```

### Disable Demo Mode

Set in `.env`:

```env
DEMO_MODE=false
```

All demo features are disabled. No overhead.

## Customization

### Change Reset Interval

In `config/demo.php` or `.env`:

```env
# Reset every 60 minutes instead of 30
DEMO_RESET_INTERVAL=60
```

### Add Custom Blocked Actions

In `config/demo.php`:

```php
'blocked_actions' => [
    'user.delete',
    'user.force-delete',
    'role.delete',
    'backup.run',
    'your-custom-action', // Add your own
],
```

### Customize Banner Appearance

In `config/demo.php`:

```php
'banner' => [
    'show_on_login' => true,
    'show_on_admin' => true,
    'background_color' => 'yellow-50',
    'border_color' => 'yellow-500',
    'text_color' => 'yellow-900',
],
```

### Domain Whitelisting (Security)

Only allow demo mode on specific domains:

```php
'allowed_hosts' => [
    'demo.yourdomain.com',
    'localhost',
    '127.0.0.1',
],
```

## Integration with Filament

### Display Demo Banner in Admin Dashboard

The module automatically registers a Filament widget. To display it:

**Option 1: In Dashboard Page**

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

**Option 2: In Custom Filament Page**

```php
use LaraCoreKit\DemoModule\Filament\Widgets\DemoBannerWidget;

protected function getHeaderWidgets(): array
{
    return [
        DemoBannerWidget::class,
    ];
}
```

The widget will only show when `DEMO_MODE=true`.

## UI Integration

**See [UI_INTEGRATION_GUIDE.md](UI_INTEGRATION_GUIDE.md) for complete integration examples.**

### Quick Start

**Frontend Login:**
```blade
<x-demo-login-banner type="user" />
```

**Filament Admin Login:**
```bash
# Windows PowerShell
Copy-Item "vendor\programmernomad\laracorekit-demo-module\stubs\filament-login.blade.php" `
         -Destination "resources\views\filament\pages\auth\login.blade.php"
```

## Blade Components

### Login Page Banner

Add to your login view:

```blade
<x-demo-login-banner type="user" />
```

For admin login:

```blade
<x-demo-login-banner type="admin" />
```

This displays credentials when demo mode is active.

## Security Features

### Domain Validation

In production, demo mode only works on whitelisted domains (configured in `config/demo.php`).

### Action Blocking

Destructive actions are automatically blocked via Laravel Gates:

```php
// Example: This will be denied in demo mode
Gate::allows('user.delete'); // returns false
```

### Middleware Protection

Apply middleware to routes that should block actions:

```php
Route::middleware('demo.block')->group(function () {
    // Protected routes
});
```

## What Gets Reset?

Every reset cycle cleans:

- ✅ **Database**: Fresh migrations + seeders
- ✅ **Media Files**: `storage/app/public/media/*`
- ✅ **Cache**: All cached data
- ✅ **Sessions**: Active user sessions
- ✅ **Logs**: Rotated (keeps last 7 days)

**Preserved:**
- ✅ `.env` configuration
- ✅ Compiled assets (`public/build/*`)
- ✅ Vendor packages
- ✅ Node modules

## Troubleshooting

### Cron Not Running

Check if Laravel scheduler is working:

```bash
php artisan schedule:list
```

You should see `demo:reset` scheduled.

### Demo Banner Not Showing

Clear config cache:

```bash
php artisan config:clear
php artisan view:clear
```

Verify `.env`:

```bash
php artisan tinker
>>> config('demo.enabled') // Should return true
```

### Reset Fails

Check logs:

```bash
tail -f storage/logs/laravel.log
```

Run manually with verbose output:

```bash
php artisan demo:reset --force -vvv
```

### Media Files Not Deleting

Check permissions:

```bash
ls -la storage/app/public/media/
chmod -R 775 storage/app/public/media/
```

## Development

### Local Development

Clone and link locally:

```bash
# Clone repo
git clone https://github.com/programmernomad/laracorekit-demo-module.git

# In your Laravel project's composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "../aracorekit-demo-module",
            "options": {
                "symlink": true
            }
        }
    ],
    "require-dev": {
        "programmernomad/laracorekit-demo-module": "@dev"
    }
}

# Install
composer update programmernomad/laracorekit-demo-module
```

### Testing

```bash
# Run package tests
composer test

# Code style (Laravel Pint)
composer pint
```

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for recent changes.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Security

If you discover any security issues, please email security@example.com instead of using the issue tracker.

## Credits

- [ProgrammerNomad](https://github.com/ProgrammerNomad)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

## Support

- **Issues**: [GitHub Issues](https://github.com/programmernomad/laracorekit-demo-module/issues)
- **Discussions**: [GitHub Discussions](https://github.com/programmernomad/laracorekit-demo-module/discussions)
- **Documentation**: [Full Setup Guide](https://github.com/ProgrammerNomad/LaraCoreKit/blob/main/DEMO_SETUP.md)

## Related Projects

- [LaraCoreKit](https://github.com/ProgrammerNomad/LaraCoreKit) - Laravel 12 starter kit with modular architecture
- [Demo Website](https://laracorekit.mobrilz.digital/) - Live demo powered by this module

---

**Made with ❤️ for the Laravel community**
