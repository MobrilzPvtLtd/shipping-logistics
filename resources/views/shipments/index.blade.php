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
                            <a href="{{ route('shipments.invoices.index', $shipment) }}" class="group inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-900" title="{{ __('Invoices') }}" aria-label="{{ __('Invoices') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M9 12h6" />
                                    <path d="M9 16h6" />
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                    <path d="M14 2v6h6" />
                                </svg>
                                <span class="hidden group-hover:inline text-xs font-medium">{{ __('Invoices') }}</span>
                            </a>
                            <a href="{{ route('shipments.invoices.create', $shipment) }}" class="group inline-flex items-center gap-2 text-green-600 hover:text-green-900" title="{{ __('Add Invoice') }}" aria-label="{{ __('Add Invoice') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M12 5v14" />
                                    <path d="M5 12h14" />
                                    <path d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                </svg>
                                <span class="hidden group-hover:inline text-xs font-medium">{{ __('Add Invoice') }}</span>
                            </a>
                            <a href="{{ route('shipments.compliance-documents.index', $shipment) }}" class="group inline-flex items-center gap-2 text-teal-600 hover:text-teal-900" title="{{ __('Compliance Docs') }}" aria-label="{{ __('Compliance Docs') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
                                <span class="hidden group-hover:inline text-xs font-medium">{{ __('Compliance Docs') }}</span>
                            </a>

                            @if ($shipment->status === 'pending')
                                <a href="{{ route('shipments.edit', $shipment) }}" class="group inline-flex items-center gap-2 text-blue-600 hover:text-blue-900" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                    <span class="hidden group-hover:inline text-xs font-medium">{{ __('Edit') }}</span>
                                </a>
                                <form method="POST" action="{{ route('shipments.destroy', $shipment) }}" onsubmit="return confirm('{{ __('Delete this shipment?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="group inline-flex items-center gap-2 text-red-600 hover:text-red-900" title="{{ __('Delete') }}" aria-label="{{ __('Delete') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                            <path d="M3 6h18" />
                                            <path d="M8 6v14a2 2 0 002 2h4a2 2 0 002-2V6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                                        </svg>
                                        <span class="hidden group-hover:inline text-xs font-medium">{{ __('Delete') }}</span>
                                    </button>
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
