@extends('core::layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">{{ __('Generate Commercial Invoice') }} - {{ $shipment->tracking_number }}</h1>
        <a href="{{ route('shipments.invoices.index', $shipment) }}" class="text-blue-600 hover:underline">{{ __('Back to invoices') }}</a>
    </div>

    <form method="POST" action="{{ route('shipments.invoices.store', $shipment) }}" enctype="multipart/form-data" class="bg-white shadow-lg border border-gray-400 text-xs">
        @csrf

        <!-- Top Header -->
        <div class="bg-stone-100 p-2 border-b border-gray-400 text-center font-bold text-lg uppercase tracking-wider">
            {{ __('Commercial Invoice') }}
        </div>

        <!-- Date & Invoice No -->
        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="p-2 border-r border-gray-400">
                <label class="block text-[10px] uppercase font-bold text-gray-600">{{ __('Date') }}</label>
                <input type="date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" class="w-full border-none p-0 focus:ring-0 text-sm" />
            </div>
            <div class="p-2">
                <label class="block text-[10px] uppercase font-bold text-gray-600">{{ __('Invoice No.') }}</label>
                <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="w-full border-none p-0 focus:ring-0 text-sm" placeholder="e.g. INV-1001" />
            </div>
        </div>

        <!-- Exporter & Consignee Row -->
        <div class="grid grid-cols-2 border-b border-gray-400">
            <!-- Exporter -->
            <div class="p-2 border-r border-gray-400 space-y-1">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-600">{{ __('Exporter') }}</label>
                    <input name="exporter_name" value="{{ old('exporter_name') }}" class="w-full border-none p-0 focus:ring-0 font-semibold" />
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Address') }}</label>
                    <textarea name="exporter_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('exporter_address') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">{{ __('City/State/ZIP') }}</label>
                        <input name="exporter_city_zip" class="w-full border-none p-0 focus:ring-0" />
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">{{ __('Country') }}</label>
                        <input name="exporter_country" class="w-full border-none p-0 focus:ring-0" />
                    </div>
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Phone/Fax') }}</label>
                    <input name="exporter_phone" class="w-full border-none p-0 focus:ring-0" />
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Contact Person') }}</label>
                    <input name="contact_person" class="w-full border-none p-0 focus:ring-0" />
                </div>
            </div>

            <!-- Consignee -->
            <div class="p-2 space-y-1">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-600">{{ __('Consignee') }}</label>
                    <input name="consignee_name" value="{{ old('consignee_name') }}" class="w-full border-none p-0 focus:ring-0 font-semibold" />
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Address') }}</label>
                    <textarea name="consignee_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('consignee_address') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">{{ __('City/State/ZIP') }}</label>
                        <input name="consignee_city_zip" class="w-full border-none p-0 focus:ring-0" />
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">{{ __('Country') }}</label>
                        <input name="consignee_country" class="w-full border-none p-0 focus:ring-0" />
                    </div>
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Phone/Fax') }}</label>
                    <input name="consignee_phone" class="w-full border-none p-0 focus:ring-0" />
                </div>
                <div>
                    <label class="text-[10px] text-gray-500 uppercase">{{ __('Contact Person') }}</label>
                    <input name="consignee_contact" class="w-full border-none p-0 focus:ring-0" />
                </div>
            </div>
        </div>

        <!-- Logistics Grid -->
        <div class="grid grid-cols-12 border-b border-gray-400 h-32">
            <div class="col-span-2 border-r border-b border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Tax ID No (EIN)') }}</label>
                <input name="reference_tax_id" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-b border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Total Gross Weight') }}</label>
                <input name="total_gross_weight" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-b border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Transportation') }}</label>
                <input name="transportation" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-b border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Tax ID No (EIN)') }}</label>
                <input name="consignee_tax_id" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-4 border-b border-gray-400 p-1 row-span-2">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Terms of Sale') }}</label>
                <textarea name="terms_of_sale" class="w-full border-none p-0 focus:ring-0 resize-none h-20"></textarea>
            </div>

            <!-- Second Row of Logistics -->
            <div class="col-span-2 border-r border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Other') }}</label>
                <input name="other_info" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Total # of Pieces') }}</label>
                <input name="total_pieces" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('AWB/BL#') }}</label>
                <input name="awb_bl_number" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
            <div class="col-span-2 border-r border-gray-400 p-1">
                <label class="block text-[9px] uppercase font-bold leading-tight">{{ __('Currency') }}</label>
                <input name="currency" value="USD" class="w-full border-none p-0 focus:ring-0 mt-2" />
            </div>
        </div>

        <!-- Commodity Table Header -->
        <div class="grid grid-cols-12 border-b border-gray-400 bg-gray-50 text-center font-bold text-[10px] uppercase">
            <div class="col-span-3 border-r border-gray-400 p-1 py-2">{{ __('Commodity Description') }}</div>
            <div class="col-span-1 border-r border-gray-400 p-1 py-2">{{ __('HS') }}</div>
            <div class="col-span-2 border-r border-gray-400 p-1 py-2">{{ __('Country of Manufacture') }}</div>
            <div class="col-span-1 border-r border-gray-400 p-1 py-2">{{ __('QTY') }}</div>
            <div class="col-span-1 border-r border-gray-400 p-1 py-2">{{ __('UOM') }}</div>
            <div class="col-span-2 border-r border-gray-400 p-1 py-2">{{ __('Unit Price') }}</div>
            <div class="col-span-2 p-1 py-2">{{ __('Total Amount') }}</div>
        </div>

        <!-- Commodity Table Body -->
        <div class="grid grid-cols-12 border-b border-gray-400 min-h-[300px]">
            <div class="col-span-3 border-r border-gray-400 p-1">
                <textarea name="commodity_description" class="w-full h-full border-none p-1 focus:ring-0 text-[11px] resize-none"></textarea>
            </div>
            <div class="col-span-1 border-r border-gray-400 p-1">
                <input name="hs_code" class="w-full border-none p-1 focus:ring-0 text-center" />
            </div>
            <div class="col-span-2 border-r border-gray-400 p-1">
                <input name="country_of_manufacture" class="w-full border-none p-1 focus:ring-0 text-center" />
            </div>
            <div class="col-span-1 border-r border-gray-400 p-1">
                <input type="number" name="quantity" class="w-full border-none p-1 focus:ring-0 text-center" />
            </div>
            <div class="col-span-1 border-r border-gray-400 p-1">
                <input name="uom" class="w-full border-none p-1 focus:ring-0 text-center" placeholder="PCS" />
            </div>
            <div class="col-span-2 border-r border-gray-400 p-1">
                <input name="unit_price" class="w-full border-none p-1 focus:ring-0 text-right" />
            </div>
            <div class="col-span-2 p-1">
                <input name="line_total" class="w-full border-none p-1 focus:ring-0 text-right font-semibold" />
            </div>
        </div>

        <!-- Footer Section -->
        <div class="grid grid-cols-12">
            <!-- Left Legal Text -->
            <div class="col-span-6 p-4 text-[9px] border-r border-gray-400 italic text-gray-600 leading-tight">
                {{ __('These commodities, technologies, or software were exported from the United States in accordance with export administration regulations. Diversions contrary to United States law prohibited. We certify that this commercial invoice is true and correct.') }}

                <div class="mt-6 border-t border-dashed pt-2">
                    <label class="block text-[10px] uppercase font-bold not-italic">{{ __('Attachment / Digital Copy') }}</label>
                    <input type="file" name="invoice_file" class="mt-2 text-[10px]" />
                </div>
            </div>

            <!-- Right Totals -->
            <div class="col-span-6">
                <div class="grid grid-cols-3 border-b border-gray-400 bg-stone-50">
                    <div class="col-span-2 border-r border-gray-400 p-2 font-bold uppercase">{{ __('Subtotal') }}</div>
                    <div class="p-2 text-right"><input name="subtotal_amount" class="w-full border-none p-0 focus:ring-0 bg-transparent text-right" /></div>
                </div>
                <div class="grid grid-cols-3 border-b border-gray-400">
                    <div class="col-span-2 border-r border-gray-400 p-2 font-bold uppercase">{{ __('Freight Cost') }}</div>
                    <div class="p-2 text-right"><input name="freight_cost" class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                </div>
                <div class="grid grid-cols-3 border-b border-gray-400 bg-stone-50">
                    <div class="col-span-2 border-r border-gray-400 p-2 font-bold uppercase">{{ __('Insurance Cost') }}</div>
                    <div class="p-2 text-right"><input name="insurance_cost" class="w-full border-none p-0 focus:ring-0 bg-transparent text-right" /></div>
                </div>
                <div class="grid grid-cols-3 bg-stone-100">
                    <div class="col-span-2 border-r border-gray-400 p-2 font-black uppercase text-sm">{{ __('Total Invoice Value') }}</div>
                    <div class="p-2 text-right"><input name="total_invoice_value" class="w-full border-none p-0 focus:ring-0 bg-transparent text-right font-bold text-sm" /></div>
                </div>
            </div>
        </div>

        <!-- Certification & Signature -->
        <div class="border-t border-gray-400 p-2 text-[10px]">
            <p class="mb-4">{{ __('I/we hereby certify that the information on this invoice is true and correct and that the contents of this shipment are as stated above.') }}</p>
            <div class="grid grid-cols-12 gap-0 border border-gray-400">
                <div class="col-span-4 border-r border-gray-400 p-1 h-12">
                    <label class="block uppercase font-bold text-[8px]">{{ __('Name') }}</label>
                    <input name="signer_name" class="w-full border-none p-0 focus:ring-0" />
                </div>
                <div class="col-span-5 border-r border-gray-400 p-1 h-12">
                    <label class="block uppercase font-bold text-[8px]">{{ __('Signature') }}</label>
                    <div class="w-full h-6 border-b border-gray-200 border-dotted"></div>
                </div>
                <div class="col-span-3 p-1 h-12">
                    <label class="block uppercase font-bold text-[8px]">{{ __('Date') }}</label>
                    <input type="date" name="signature_date" class="w-full border-none p-0 focus:ring-0" />
                </div>
            </div>
        </div>

        <!-- Submission UI -->
        <div class="bg-gray-100 p-4 flex justify-end gap-3 border-t border-gray-400">
            <button type="submit" class="px-6 py-2 bg-blue-700 text-white font-bold rounded shadow hover:bg-blue-800 uppercase text-xs">
                {{ __('Upload and Finalize Invoice') }}
            </button>
        </div>
    </form>
</div>

<style>
    /* Ensure borders look crisp like a table */
    input:focus, textarea:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
@endsection
