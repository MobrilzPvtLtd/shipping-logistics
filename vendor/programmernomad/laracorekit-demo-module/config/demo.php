<?php

return [
    'enabled' => env('DEMO_MODE', false),

    'reset_interval' => env('DEMO_RESET_INTERVAL', 30),

    'credentials' => [
        'admin' => [
            'email' => env('DEMO_ADMIN_EMAIL', 'admin@demo.test'),
            'password' => env('DEMO_ADMIN_PASSWORD', 'Admin@123'),
        ],
        'user' => [
            'email' => env('DEMO_USER_EMAIL', 'user@demo.test'),
            'password' => env('DEMO_USER_PASSWORD', 'User@123'),
        ],
    ],

    'allowed_hosts' => [
        'laracorekit.mobrilz.digital',
        'localhost',
        '127.0.0.1',
    ],

    'blocked_actions' => [
        'user.delete',
        'user.force-delete',
        'role.delete',
        'permission.delete',
        'backup.run',
        'backup.delete',
        'telescope.clear',
        'cache.clear',
        'settings.update-critical',
    ],

    'reset' => [
        'clear_media' => true,
        'clear_cache' => true,
        'clear_sessions' => true,
        'preserve_logs_days' => 7,
    ],

    'banner' => [
        'show_on_login' => true,
        'show_on_admin' => true,
        'background_color' => 'yellow-50',
        'border_color' => 'yellow-500',
        'text_color' => 'yellow-900',
    ],
];
