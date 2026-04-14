<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Shipments') }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Track and manage shipment records') }}</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 px-3 py-1 text-xs font-semibold">
                {{ $this->getShipmentsCount() }}
            </span>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('shipments.index') }}" class="block rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4 text-sm font-medium text-gray-900 dark:text-gray-100 hover:border-blue-500 hover:text-blue-600 transition">
                {{ __('View Shipments') }}
            </a>
            @can('create-shipments')
                <a href="{{ route('shipments.create') }}" class="block rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4 text-sm font-medium text-gray-900 dark:text-gray-100 hover:border-indigo-500 hover:text-indigo-600 transition">
                    {{ __('Create Shipment') }}
                </a>
            @endcan
        </div>
    </div>
</div>
