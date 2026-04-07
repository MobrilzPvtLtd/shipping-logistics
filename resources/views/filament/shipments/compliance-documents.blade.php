@php
$documents = $record->compliance_documents ?? [];
$documentTypes = [
    'cbp_form_5106' => 'CBP Form 5106',
    'power_of_attorney' => 'Power of Attorney',
    'vi_excise_tax_credit_card_form' => 'VI Excise Tax Credit Card Form',
];
@endphp

<div class="mt-6 rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 px-6 py-5">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Compliance Documents') }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ __('Uploaded compliance documents for this shipment.') }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto px-6 py-4">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th scope="col" class="whitespace-nowrap px-4 py-3">{{ __('Document') }}</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3">{{ __('Status') }}</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3">{{ __('File') }}</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3">{{ __('Uploaded At') }}</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($documentTypes as $key => $label)
                    @php
                        $document = $documents[$key] ?? [];
                        $status = $document['status'] ?? null;
                        $path = $document['path'] ?? null;
                        $uploadedAt = $document['uploaded_at'] ?? null;
                    @endphp
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-4 font-medium text-gray-900">{{ $label }}</td>
                        <td class="px-4 py-4">
                            @if ($status === 'accepted')
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-800">{{ __('Accepted') }}</span>
                            @elseif ($status === 'rejected')
                                <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-rose-800">{{ __('Rejected') }}</span>
                            @elseif ($path)
                                <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-sky-800">{{ __('Uploaded') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-gray-700">{{ __('Not uploaded') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $path ? basename($path) : '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $uploadedAt ?: '-' }}</td>
                        <td class="px-4 py-4">
                            @if ($path)
                                <a href="{{ route('shipments.compliance-documents.download', [$record, $key]) }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-700">{{ __('Download') }}</a>
                            @else
                                <span class="text-sm text-gray-500">{{ __('No file') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
