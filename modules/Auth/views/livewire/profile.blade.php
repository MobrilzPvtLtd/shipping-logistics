<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('My Profile') }}</h1>

            @if(session('status'))
                <div class="mb-4 text-sm text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 p-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-6 text-gray-700 dark:text-gray-300">
                <p><strong>{{ __('Role') }}:</strong> {{ auth()->user()->getRoleNames()->implode(', ') ?: __('None') }}</p>
                <p><strong>{{ __('Member since') }}:</strong> {{ auth()->user()->created_at->format('M d, Y') }}</p>
            </div>

            <form wire:submit.prevent="updateProfile" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                        <input wire:model.defer="name" type="text" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                        @error('name') <p class="text-sm text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                        <input wire:model.defer="email" type="email" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                        @error('email') <p class="text-sm text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 text-sm text-gray-700 dark:text-gray-300">
                    <p class="font-medium mb-2">{{ __('Change Password (optional)') }}</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Current Password') }}</label>
                            <input wire:model.defer="current_password" type="password" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                            @error('current_password') <p class="text-sm text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('New Password') }}</label>
                            <input wire:model.defer="new_password" type="password" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                            @error('new_password') <p class="text-sm text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Confirm New Password') }}</label>
                            <input wire:model.defer="new_password_confirmation" type="password" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                        </div>
                    </div>
                </div>

                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    {{ __('Save Changes') }}
                </button>
            </form>
        </div>
    </div>
</div>
