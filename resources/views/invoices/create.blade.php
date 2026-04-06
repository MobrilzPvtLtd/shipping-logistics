@extends('core::layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 font-sans text-gray-900">
        <!-- Header Navigation -->
        <div class="flex items-center justify-between mb-4 print:hidden">
            <h1 class="text-xl font-bold uppercase tracking-tight text-gray-700">{{ __('Generate Commercial Invoice') }}</h1>
            <a href="{{ route('shipments.invoices.index', $shipment) }}"
                class="text-blue-600 hover:underline text-sm font-medium">← {{ __('Back') }}</a>
        </div>

        @php
            $isEdit = isset($invoice);
            $invoice = $invoice ?? null;
            $oldValue = function ($name, $default = '') use ($invoice) {
                return old($name, data_get($invoice, $name, $default));
            };
        @endphp
        <!-- Main Invoice Form -->
        <form method="POST" action="{{ $isEdit ? route('shipments.invoices.update', [$shipment, $invoice]) : route('shipments.invoices.store', $shipment) }}" enctype="multipart/form-data"
            class="bg-white border-[1.5px] border-black text-[11px] leading-tight">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="p-4 border border-red-200 bg-red-50 text-red-700 mb-4">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. TOP HEADER -->
            <div class="bg-[#f1eeea] p-2 border-b border-black text-center font-bold text-lg uppercase tracking-widest">
                {{ $isEdit ? __('Edit Commercial Invoice') : __('Commercial Invoice') }}
            </div>

            <!-- 2. DATE & INVOICE NO -->
            <div class="grid grid-cols-2 border-b border-black">
                <div class="p-2 border-r border-black h-14">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Date') }}</label>
                    <input type="date" name="invoice_date"
                        value="{{ old('invoice_date', optional($invoice)->invoice_date?->format('Y-m-d') ?? date('Y-m-d')) }}"
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                </div>
                <div class="p-2 h-14">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Invoice No.') }}</label>
                    <input type="text" name="invoice_number"
                        value="{{ old('invoice_number', $invoice->invoice_number ?? '') }}"
                        placeholder="Enter number..."
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                </div>
            </div>

            <div class="grid grid-cols-1 border-b border-black">
                <div class="p-2 h-20">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Invoice Document') }}</label>
                    <input type="file" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png,.tiff"
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                    @if($isEdit && $invoice->file_path)
                        <p class="mt-1 text-xs text-gray-500">{{ __('Current file:') }} <a href="{{ route('shipments.invoices.download', [$shipment, $invoice]) }}" class="underline">{{ basename($invoice->file_path) }}</a></p>
                    @endif
                </div>
            </div>

            <!-- 3. EXPORTER & CONSIGNEE (Vertical labels inside boxes) -->
            <div class="grid grid-cols-2 border-b border-black">
                <!-- Exporter -->
                <div class="p-3 border-r border-black space-y-2">
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Exporter') }}</label><input
                            name="exporter_name" value="{{ old('exporter_name', $invoice->exporter_name ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 font-bold" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Address') }}</label>
                        <textarea name="exporter_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('exporter_address', $invoice->exporter_address ?? '') }}</textarea>
                    </div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('City/State/Zip') }}</label><input
                            name="exporter_city_zip" value="{{ old('exporter_city_zip', $invoice->exporter_city_zip ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Country') }}</label><input
                            name="exporter_country" value="{{ old('exporter_country', $invoice->exporter_country ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Phone/Fax') }}</label><input
                            name="exporter_phone" value="{{ old('exporter_phone', $invoice->exporter_phone ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Contact Person') }}</label><input
                            name="contact_person" value="{{ old('contact_person', $invoice->contact_person ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
                <!-- Consignee -->
                <div class="p-3 space-y-2">
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Consignee') }}</label><input
                            name="consignee_name" value="{{ old('consignee_name', $invoice->consignee_name ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 font-bold" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Address') }}</label>
                        <textarea name="consignee_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('consignee_address', $invoice->consignee_address ?? '') }}</textarea>
                    </div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('City/State/Zip') }}</label><input
                            name="consignee_city_zip" value="{{ old('consignee_city_zip', $invoice->consignee_city_zip ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Country') }}</label><input
                            name="consignee_country" value="{{ old('consignee_country', $invoice->consignee_country ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Phone/Fax') }}</label><input
                            name="consignee_phone" value="{{ old('consignee_phone', $invoice->consignee_phone ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Contact Person') }}</label><input
                            name="consignee_contact" value="{{ old('consignee_contact', $invoice->consignee_contact ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
            </div>

            <!-- 4. LOGISTICS GRID (Exact Grid Layout from Image) -->
            <div class="grid grid-cols-12 border-b border-black h-36">
                <!-- Left 8 Columns (4x2 grid) -->
                <div class="col-span-8 grid grid-cols-4 grid-rows-2 border-r border-black h-full">
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Tax ID No (EIN)') }}</label><input
                            name="reference_tax_id" value="{{ old('reference_tax_id', $invoice->reference_tax_id ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Total Gross Weight') }}</label><input
                            name="total_gross_weight" value="{{ old('total_gross_weight', $invoice->total_gross_weight ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Transportation') }}</label><input
                            name="transportation" value="{{ old('transportation', $invoice->transportation ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Consignee Tax ID No (EIN)') }}</label><input
                            name="consignee_tax_id" value="{{ old('consignee_tax_id', $invoice->consignee_tax_id ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>

                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Other') }}</label><input
                            name="other_info" value="{{ old('other_info', $invoice->other_info ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Total # of Pieces') }}</label><input
                            name="total_pieces" value="{{ old('total_pieces', $invoice->total_pieces ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('AWB/BL#') }}</label><input
                            name="awb_bl_number" value="{{ old('awb_bl_number', $invoice->awb_bl_number ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Currency') }}</label><input name="currency"
                            value="{{ old('currency', $invoice->currency ?? 'USD') }}" class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
                <!-- Right 4 Columns (Terms of Sale) -->
                <div class="col-span-4 p-2 h-full">
                    <label class="block text-[9px] font-bold uppercase mb-1">{{ __('Terms of Sale') }}</label>
                    <textarea name="terms_of_sale" class="w-full border-none p-0 focus:ring-0 resize-none h-24">{{ old('terms_of_sale', $invoice->terms_of_sale ?? '') }}</textarea>
                </div>
            </div>

            <!-- 5 & 6: REDESIGNED COMMODITY ROW (Label at top, Input below) -->
            <div class="grid grid-cols-12 border-b border-black divide-x divide-black bg-white min-h-[300px]">
                <!-- Commodity Description -->
                <div class="col-span-3 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('Commodity Description') }}
                    </div>
                    <div class="p-2 grow flex">
                        <textarea name="commodity_description"
                            class="w-full h-full border-none p-0 focus:ring-0 resize-none text-[11px] leading-tight bg-transparent">{{ old('commodity_description', $invoice->commodity_description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- HS -->
                <div class="col-span-1 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('HS') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="hs_code"
                            value="{{ old('hs_code', $invoice->hs_code ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                    </div>
                </div>

                <!-- Country of Manufacture -->
                <div class="col-span-2 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[8px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center leading-none">
                        {{ __('Country of Manufacture') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="country_of_manufacture"
                            value="{{ old('country_of_manufacture', $invoice->country_of_manufacture ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                    </div>
                </div>

                <!-- QTY -->
                <div class="col-span-1 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('QTY') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="quantity"
                            value="{{ old('quantity', $invoice->quantity ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                    </div>
                </div>

                <!-- UOM -->
                <div class="col-span-1 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('UOM') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="uom"
                            value="{{ old('uom', $invoice->uom ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                    </div>
                </div>

                <!-- Unit Price -->
                <div class="col-span-2 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('Unit Price') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="unit_price"
                            value="{{ old('unit_price', $invoice->unit_price ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] bg-transparent" />
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="col-span-2 flex flex-col h-full">
                    <div
                        class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                        {{ __('Total Amount') }}
                    </div>
                    <div class="p-2 grow flex items-start">
                        <input name="line_total"
                            value="{{ old('line_total', $invoice->line_total ?? '') }}"
                            class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] font-bold bg-transparent" />
                    </div>
                </div>
            </div>

            <!-- 7. FOOTER: LEGAL + TOTALS -->
            <div class="grid grid-cols-12 h-44">
                <!-- Legal Text -->
                <div class="col-span-7 p-4 text-[9px] italic border-r border-black leading-tight text-gray-700">
                    {{ __('These commodities, technologies, or software were exported from the United States in accordance with export administration regulations. Diversions contrary to United States law prohibited. We certify that this commercial invoice is true and correct.') }}
                </div>
                <!-- Totals Section -->
                <div class="col-span-5 flex flex-col border-l border-black">
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div
                            class="col-span-2 bg-[#f1eeea] border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Subtotal') }}</div>
                        <div class="p-2 flex items-center"><input name="subtotal_amount"
                                value="{{ old('subtotal_amount', $invoice->subtotal_amount ?? '') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div class="col-span-2 border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Freight Cost') }}</div>
                        <div class="p-2 flex items-center"><input name="freight_cost"
                                value="{{ old('freight_cost', $invoice->freight_cost ?? '') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div
                            class="col-span-2 bg-[#f1eeea] border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Insurance Cost') }}</div>
                        <div class="p-2 flex items-center"><input name="insurance_cost"
                                value="{{ old('insurance_cost', $invoice->insurance_cost ?? '') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 h-1/4 bg-[#f1eeea]">
                        <div
                            class="col-span-2 border-r border-black p-2 font-black uppercase text-[12px] flex items-center">
                            {{ __('Total Invoice Value') }}</div>
                        <div class="p-2 flex items-center"><input name="total_invoice_value"
                                value="{{ old('total_invoice_value', $invoice->total_invoice_value ?? '') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right font-black text-sm" /></div>
                    </div>
                </div>
            </div>

            <!-- 8. BOTTOM CERTIFICATION -->
            <div class="border-t border-black p-3">
                <p class="mb-4 text-[10px] font-medium">
                    {{ __('I/we hereby certify that the information on this invoice is true and correct and that the contents of this shipment are as stated above.') }}
                </p>

                <div class="grid grid-cols-3 border border-black h-44">
                    <div class="border-r border-black p-2">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Name') }}</label>
                        <input name="signer_name" value="{{ old('signer_name', $invoice->signer_name ?? '') }}" class="w-full border-none p-0 focus:ring-0 text-[11px] font-bold" />
                    </div>
                    <div class="border-r border-black p-2 flex flex-col">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Signature') }}</label>
                        <canvas id="signatureCanvas" width="400" height="120" class="border border-gray-300 rounded-lg bg-white w-full"></canvas>
                        <div class="mt-2 flex gap-2">
                            <button type="button" id="clearSignature" class="px-3 py-1 bg-gray-200 rounded text-xs">{{ __('Clear') }}</button>
                            <button type="button" id="saveSignature" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">{{ __('Save') }}</button>
                        </div>
                        <input type="hidden" name="signature_data" id="signature_data" value="{{ old('signature_data', $invoice->signature_data ?? '') }}">
                        <div id="signature_preview" class="mt-2"></div>
                    </div>
                    <div class="p-2">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Date') }}</label>
                        <input type="date" name="signature_date" value="{{ old('signature_date', optional($invoice)->signature_date?->format('Y-m-d') ?? '') }}" class="w-full border-none p-0 focus:ring-0 text-[11px]" />
                    </div>
                </div>
            </div>

            <!-- Submit UI (Hidden on Print) -->
            <div class="bg-gray-100 p-4 border-t border-black flex justify-end print:hidden">
                <button type="submit"
                    class="bg-black text-white px-8 py-2 rounded-sm font-bold uppercase text-xs tracking-widest hover:bg-gray-900 transition-colors">
                    {{ __('Finalize Invoice') }}
                </button>
            </div>
        </form>
    </div>

    <style>
        input,
        textarea {
            background: transparent !important;
        }

        input:focus,
        textarea:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        @media print {
            .print\:hidden {
                display: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('signatureCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let drawing = false;
            let lastX = 0;
            let lastY = 0;
            let hasDrawn = false;

            function getPosition(event) {
                const rect = canvas.getBoundingClientRect();
                const x = event.touches ? event.touches[0].clientX - rect.left : event.clientX - rect.left;
                const y = event.touches ? event.touches[0].clientY - rect.top : event.clientY - rect.top;
                return { x, y };
            }

            function startDraw(event) {
                event.preventDefault();
                drawing = true;
                const pos = getPosition(event);
                lastX = pos.x;
                lastY = pos.y;
            }

            function draw(event) {
                if (!drawing) return;
                event.preventDefault();
                const pos = getPosition(event);
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                lastX = pos.x;
                lastY = pos.y;
                hasDrawn = true;
            }

            function stopDraw() {
                drawing = false;
            }

            canvas.addEventListener('mousedown', startDraw);
            canvas.addEventListener('touchstart', startDraw, { passive: false });
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('mouseup', stopDraw);
            canvas.addEventListener('mouseleave', stopDraw);
            canvas.addEventListener('touchend', stopDraw);
            canvas.addEventListener('touchcancel', stopDraw);

            const signatureInput = document.getElementById('signature_data');
            const signaturePreview = document.getElementById('signature_preview');
            const form = canvas.closest('form');

            function renderPreview(dataUrl) {
                signaturePreview.innerHTML = dataUrl ? '<img src="' + dataUrl + '" class="h-20 border border-gray-300 rounded" />' : '';
            }

            function loadSignatureOnCanvas(dataUrl) {
                if (!dataUrl) {
                    return;
                }

                const image = new Image();
                image.onload = function () {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#fff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
                };
                image.src = dataUrl;
            }

            document.getElementById('clearSignature').addEventListener('click', function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                signatureInput.value = '';
                hasDrawn = false;
                renderPreview('');
            });

            document.getElementById('saveSignature').addEventListener('click', function () {
                const dataUrl = canvas.toDataURL('image/png');
                signatureInput.value = dataUrl;
                renderPreview(dataUrl);
                hasDrawn = false;
            });

            if (signatureInput.value) {
                renderPreview(signatureInput.value);
                loadSignatureOnCanvas(signatureInput.value);
            }

            if (form) {
                form.addEventListener('submit', function () {
                    if (hasDrawn && !signatureInput.value) {
                        const dataUrl = canvas.toDataURL('image/png');
                        signatureInput.value = dataUrl;
                        renderPreview(dataUrl);
                    }
                });
            }
        });
    </script>
@endsection
