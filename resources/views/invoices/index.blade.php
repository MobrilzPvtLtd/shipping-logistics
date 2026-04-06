@extends('core::layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 mt-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ __('Invoices for shipment') }} {{ $shipment->tracking_number }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Shipment ID') }}: {{ $shipment->id }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">{{ __('Back to shipments') }}</a>
            <a href="{{ route('shipments.invoices.create', $shipment) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Add Invoice') }}</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 rounded border border-green-200">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Invoice #') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Date') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Currency') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total Value') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('File') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-900">
                @forelse ($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->invoice_number ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ optional($invoice->invoice_date)->format('Y-m-d') ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->currency ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->total_invoice_value ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ basename($invoice->file_path ?? '') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200 flex gap-2">
                            <a href="{{ route('shipments.invoices.edit', [$shipment, $invoice]) }}" class="text-indigo-600">{{ __('Edit') }}</a>
                            @if($invoice->file_path)
                                <a href="{{ route('shipments.invoices.download', [$shipment, $invoice]) }}" class="text-blue-600">{{ __('Download') }}</a>
                            @endif
                            <form method="POST" action="{{ route('shipments.invoices.destroy', [$shipment, $invoice]) }}" onsubmit="return confirm('{{ __('Delete this invoice?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No invoices uploaded yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
