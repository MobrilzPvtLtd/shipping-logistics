@extends('core::layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 mt-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ __('Compliance Documents for shipment') }} {{ $shipment->tracking_number }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Shipment ID') }}: {{ $shipment->id }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">{{ __('Back to shipments') }}</a>
            <a href="{{ route('shipments.invoices.index', $shipment) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Invoices') }}</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Document') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('File') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Uploaded At') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-900">
                @php
                    $documentTypes = [
                        'cbp_form_5106' => 'CBP Form 5106',
                        'power_of_attorney' => 'Power of Attorney',
                        'vi_excise_tax_credit_card_form' => 'VI Excise Tax Credit Card Form',
                    ];
                @endphp
                @foreach($documentTypes as $key => $label)
                    @php
                        $document = $documents[$key] ?? null;
                        $status = data_get($document, 'status');
                    @endphp
                    <tr>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $label }}</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-200">
                            @if($status === 'accepted')
                                <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 px-2.5 py-1 text-[11px] font-semibold">{{ __('Accepted') }}</span>
                            @elseif($status === 'rejected')
                                <span class="inline-flex items-center rounded-full bg-red-100 text-red-800 px-2.5 py-1 text-[11px] font-semibold">{{ __('Rejected') }}</span>
                            @elseif(!empty($document['path']))
                                <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-800 px-2.5 py-1 text-[11px] font-semibold">{{ __('Uploaded') }}</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2.5 py-1 text-[11px] font-semibold">{{ __('Not uploaded') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-200">{{ basename($document['path'] ?? '') ?: '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $document['uploaded_at'] ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-200 flex flex-wrap gap-2">
                            @if(!empty($document['path']))
                                <a href="{{ route('shipments.compliance-documents.download', [$shipment, $key]) }}" class="text-blue-600 hover:text-blue-900">{{ __('Download') }}</a>
                            @else
                                <span class="text-gray-500">{{ __('No file') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
