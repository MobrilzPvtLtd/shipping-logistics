@extends('core::layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 mt-4 sm:px-6 lg:px-8">
    @php $isWarehouse = auth()->user()->hasRole('Warehouse Staff'); @endphp
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ $isWarehouse ? __('Submitted Shipments') : __('My Shipments') }}</h1>
        @unless($isWarehouse)
            <a href="{{ route('shipments.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-700 transition">
                {{ __('Create Shipment') }}
            </a>
        @endunless
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-900 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Tracking #') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Importer') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Contact') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Sender') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Receiver') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Created') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-900">
                @forelse ($shipments as $shipment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $shipment->tracking_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $shipment->importer_name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $shipment->phone ?? '-' }}<br>
                            {{ $shipment->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $shipment->sender_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $shipment->receiver_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200">{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $shipment->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm flex flex-wrap gap-3 items-center">
                            <a href="{{ route('shipments.invoices.index', $shipment) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Invoices') }}</a>
                            <a href="{{ route('shipments.invoices.create', $shipment) }}" class="text-green-600 hover:text-green-900">{{ __('Add Invoice') }}</a>

                            @if ($shipment->status === 'pending')
                                <a href="{{ route('shipments.edit', $shipment) }}" class="text-blue-600 hover:text-blue-900">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ route('shipments.destroy', $shipment) }}" onsubmit="return confirm('{{ __('Delete this shipment?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                </form>
                            @else
                                <span class="text-gray-500">{{ __('Locked') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No shipments yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5 flex justify-center">
        {{ $shipments->links() }}
    </div>
</div>
@endsection
