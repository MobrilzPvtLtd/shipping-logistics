@extends('core::layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 font-sans text-gray-900">
        <div class="flex items-center justify-between mb-4 print:hidden">
            <h1 class="text-xl font-bold uppercase tracking-tight text-gray-700">{{ __('Shipment Details') }}</h1>
            <a href="{{ route('shipments.index') }}" class="text-blue-600 hover:underline text-sm font-medium">← {{ __('Back to Shipments') }}</a>
        </div>

        @if (session('status'))
            <div class="p-4 mb-4 border border-green-200 bg-green-50 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-black p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Invoice Date') }}</p>
                    <p class="font-semibold">{{ $shipment->invoice_date?->format('Y-m-d') }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Invoice Number') }}</p>
                    <p class="font-semibold">{{ $shipment->invoice_number }}</p>
                </div>
            </div>

            @if ($shipment->invoice_file_path)
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Invoice Document') }}</p>
                    <a href="{{ asset('storage/' . $shipment->invoice_file_path) }}" target="_blank"
                        class="text-blue-600 hover:underline text-sm">{{ __('Download file') }}</a>
                </div>
            @endif

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Exporter') }}</p>
                <p class="font-semibold">{{ $shipment->exporter_name }}</p>
                <p>{{ $shipment->exporter_address }}</p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Consignee') }}</p>
                <p class="font-semibold">{{ $shipment->consignee_name }}</p>
                <p>{{ $shipment->consignee_address }}</p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Commodities') }}</p>
                @if (!empty($shipment->commodities))
                    <table class="w-full text-left text-[11px] border-collapse border border-black">
                        <thead>
                            <tr>
                                <th class="border border-black p-2">{{ __('Commodity') }}</th>
                                <th class="border border-black p-2">{{ __('HS') }}</th>
                                <th class="border border-black p-2">{{ __('Country') }}</th>
                                <th class="border border-black p-2">{{ __('QTY') }}</th>
                                <th class="border border-black p-2">{{ __('UOM') }}</th>
                                <th class="border border-black p-2">{{ __('Price') }}</th>
                                <th class="border border-black p-2">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipment->commodities as $commodity)
                                <tr>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'commodity_description') ?? data_get($commodity, 'description') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'hs_code') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'country_of_manufacture') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'quantity') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'uom') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'unit_price') ?? data_get($commodity, 'value') ?? '-' }}</td>
                                    <td class="border border-black p-2">{{ data_get($commodity, 'line_total') ?? data_get($commodity, 'value') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-gray-500">{{ __('No commodities were saved.') }}</p>
                @endif
            </div>

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">{{ __('Packages') }}</p>
                @if ($shipment->packages->isNotEmpty())
                    <table class="w-full text-left text-[11px] border-collapse border border-black">
                        <thead>
                            <tr>
                                <th class="border border-black p-2">{{ __('Units') }}</th>
                                <th class="border border-black p-2">{{ __('L (cm)') }}</th>
                                <th class="border border-black p-2">{{ __('W (cm)') }}</th>
                                <th class="border border-black p-2">{{ __('H (cm)') }}</th>
                                <th class="border border-black p-2">{{ __('Weight (kg)') }}</th>
                                <th class="border border-black p-2">{{ __('Notes') }}</th>
                                <th class="border border-black p-2">{{ __('Photos') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipment->packages as $package)
                                <tr>
                                    <td class="border border-black p-2">{{ $package->units }}</td>
                                    <td class="border border-black p-2">{{ $package->length_cm }}</td>
                                    <td class="border border-black p-2">{{ $package->width_cm }}</td>
                                    <td class="border border-black p-2">{{ $package->height_cm }}</td>
                                    <td class="border border-black p-2">{{ $package->weight_kg }}</td>
                                    <td class="border border-black p-2">{{ $package->condition_notes ?? '-' }}</td>
                                    <td class="border border-black p-2">
                                        @php($photos = is_array($package->photos) ? $package->photos : [])
                                        @if (count($photos))
                                            <div class="flex items-center gap-2">
                                                @foreach (array_slice($photos, 0, 3) as $photo)
                                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $photo) }}" alt="Package photo"
                                                            class="h-8 w-8 object-cover border border-black">
                                                    </a>
                                                @endforeach
                                                @if (count($photos) > 3)
                                                    <span class="text-gray-500">+{{ count($photos) - 3 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-gray-500">{{ __('No packages were saved.') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
