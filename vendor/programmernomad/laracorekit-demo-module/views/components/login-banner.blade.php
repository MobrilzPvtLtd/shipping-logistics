@if(config('demo.enabled') && config('demo.banner.show_on_login'))
<div class="bg-{{ config('demo.banner.background_color') }} border-l-4 border-{{ config('demo.banner.border_color') }} rounded-lg p-4 mb-6 shadow-sm">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-{{ config('demo.banner.text_color') }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-bold text-{{ config('demo.banner.text_color') }}">
                Demo Mode Active
            </h3>
            <div class="mt-2 text-sm text-{{ config('demo.banner.text_color') }}">
                @if($type === 'admin')
                    <p class="font-mono">
                        <strong>Admin:</strong> {{ config('demo.credentials.admin.email') }} / {{ config('demo.credentials.admin.password') }}
                    </p>
                @else
                    <p class="font-mono">
                        <strong>User:</strong> {{ config('demo.credentials.user.email') }} / {{ config('demo.credentials.user.password') }}
                    </p>
                @endif
                <p class="mt-2 text-xs opacity-75">
                    Database auto-resets every {{ config('demo.reset_interval') }} minutes. Changes won't persist.
                </p>
            </div>
        </div>
    </div>
</div>
@endif
