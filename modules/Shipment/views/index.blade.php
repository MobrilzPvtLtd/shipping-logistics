@extends('core::layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 font-sans text-gray-900">
        <div class="flex items-center justify-between mb-4 print:hidden">
            <h1 class="text-xl font-bold uppercase tracking-tight text-gray-700">{{ __('My Shipments') }}</h1>
            <a href="{{ route('shipments.create') }}" class="text-blue-600 hover:underline text-sm font-medium">{{ __('Create Shipment') }}</a>
        </div>

        @if ($shipments->isEmpty())
            <div class="p-6 border border-gray-200 rounded bg-white text-gray-700">
                {{ __('No shipments found. Use the button above to create one.') }}
            </div>
        @else
            <div class="space-y-4">
                @foreach ($shipments as $shipment)
                    <a href="{{ route('shipments.show', $shipment) }}"
                        class="block p-4 border border-black rounded bg-white hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $shipment->invoice_number ?: __('Shipment') . ' #' . $shipment->id }}</p>
                                <p class="text-sm text-gray-500">{{ $shipment->invoice_date?->format('Y-m-d') }}</p>
                            </div>
                            <span class="text-xs uppercase tracking-wider text-gray-500">{{ __('View') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
@endsection
