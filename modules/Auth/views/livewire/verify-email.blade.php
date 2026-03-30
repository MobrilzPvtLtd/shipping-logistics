<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('Verify your email address') }}</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Before you can continue, please check your email for a verification link.') }}
            </p>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                <p class="text-sm text-green-800 dark:text-green-200">{{ __('A new verification link has been sent to your email address.') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
                @csrf

                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-blue-600 hover:text-blue-500 text-sm">
                {{ __('Log out') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
