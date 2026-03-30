<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.2),transparent_50%)] pointer-events-none"></div>
            <div class="relative p-8 sm:p-10">
                <div class="flex items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('My Profile') }}</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ __('Manage your profile details and preferences.') }}</p>
                    </div>
                    <div class="flex items-center gap-3 px-3 py-2 rounded-full bg-blue-50/70 dark:bg-blue-400/20 border border-blue-200 dark:border-blue-500">
                        <span class="text-sm font-semibold text-blue-700 dark:text-blue-100">{{ __('Account') }}</span>
                        <span class="text-sm font-bold text-blue-900 dark:text-white">{{ $account_number }}</span>
                    </div>
                </div>

                @if(session('status'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/30 p-3 text-sm text-green-800 dark:text-green-100">
                        {{ session('status') }}
                    </div>
                @elseif(session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/30 p-3 text-sm text-red-800 dark:text-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="lg:col-span-2 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('Profile Info') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                                <input wire:model.defer="name" type="text" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                @error('name') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                <input wire:model.defer="email" type="email" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                @error('email') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Address') }}</label>
                                <textarea wire:model.defer="address" rows="3" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('address') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Payment Preference') }}</label>
                                <select wire:model.defer="payment_preference" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">{{ __('Choose payment option') }}</option>
                                    @foreach($paymentPreferences as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('payment_preference') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center space-x-3">
                                <input wire:model.defer="door_to_door" type="checkbox" id="door_to_door" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                <label for="door_to_door" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Door-to-door service') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-950/50 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Government ID') }}</h2>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">{{ __('Upload your verified ID document.') }}</p>
                        <div class="rounded-lg p-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ __('Status') }}: <span class="font-semibold">{{ $government_id_uploaded ? __('Uploaded') : __('Not Uploaded') }}</span></p>
                            <input wire:model="government_id_file" type="file" accept="image/*,.pdf" class="block w-full text-xs text-gray-700 dark:text-gray-200" />
                            @error('government_id_file') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                            @if($government_id_path)
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-300">{{ __('Current file:') }} <span class="font-medium truncate block max-w-full">{{ $government_id_path }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('Change Password (optional)') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Current Password') }}</label>
                            <input wire:model.defer="current_password" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('current_password') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('New Password') }}</label>
                            <input wire:model.defer="new_password" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('new_password') <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Confirm New Password') }}</label>
                            <input wire:model.defer="new_password_confirmation" type="password" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-2 mt-4 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
