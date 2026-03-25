<x-filament::widget>
    <x-filament::card>
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-yellow-900">
                        Demo Environment
                    </h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-yellow-800 font-mono">
                            <strong>Admin:</strong> {{ $this->getCredentials()['admin']['email'] }} / {{ $this->getCredentials()['admin']['password'] }}
                        </p>
                        <p class="text-sm text-yellow-800 font-mono">
                            <strong>User:</strong> {{ $this->getCredentials()['user']['email'] }} / {{ $this->getCredentials()['user']['password'] }}
                        </p>
                        <p class="text-xs text-yellow-700 mt-3">
                            Database resets automatically every <strong>{{ $this->getResetInterval() }} minutes</strong>. All changes will be lost.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
