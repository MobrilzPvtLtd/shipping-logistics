@extends('core::layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 font-sans text-gray-900">
        <div class="flex items-center justify-between mb-4 print:hidden">
            <h1 class="text-xl font-bold uppercase tracking-tight text-gray-700">{{ __('Generate Commercial Invoice') }}</h1>
            <a href="{{ route('shipments.index') }}" class="text-blue-600 hover:underline text-sm font-medium">← {{ __('Back') }}</a>
        </div>

        @if (session('status'))
            <div class="p-4 mb-4 border border-green-200 bg-green-50 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 border border-red-200 bg-red-50 text-red-700 rounded">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data"
            class="bg-white border-[1.5px] border-black text-[11px] leading-tight">
            @csrf

            <div class="bg-[#f1eeea] p-2 border-b border-black text-center font-bold text-lg uppercase tracking-widest">
                {{ __('Commercial Invoice') }}
            </div>

            <div class="grid grid-cols-2 border-b border-black">
                <div class="p-2 border-r border-black h-14">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Date') }}</label>
                    <input type="date" name="invoice_date"
                        value="{{ old('invoice_date', date('Y-m-d')) }}"
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                </div>
                <div class="p-2 h-14">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Invoice No.') }}</label>
                    <input type="text" name="invoice_number"
                        value="{{ old('invoice_number') }}"
                        placeholder="Enter number..."
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                </div>
            </div>

            <div class="grid grid-cols-1 border-b border-black">
                <div class="p-2 h-20">
                    <label class="block text-[10px] font-semibold text-gray-600 uppercase">{{ __('Invoice Document') }}</label>
                    <input type="file" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png,.tiff"
                        class="w-full border-none p-0 focus:ring-0 text-sm" />
                </div>
            </div>

            <div class="grid grid-cols-2 border-b border-black">
                <div class="p-3 border-r border-black space-y-2">
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Exporter') }}</label><input
                            name="exporter_name" value="{{ old('exporter_name') }}"
                            class="w-full border-none p-0 focus:ring-0 font-bold" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Address') }}</label>
                        <textarea name="exporter_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('exporter_address') }}</textarea>
                    </div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('City/State/Zip') }}</label><input
                            name="exporter_city_zip" value="{{ old('exporter_city_zip') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Country') }}</label><input
                            name="exporter_country" value="{{ old('exporter_country') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Phone/Fax') }}</label><input
                            name="exporter_phone" value="{{ old('exporter_phone') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Contact Person') }}</label><input
                            name="contact_person" value="{{ old('contact_person') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
                <div class="p-3 space-y-2">
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Consignee') }}</label><input
                            name="consignee_name" value="{{ old('consignee_name') }}"
                            class="w-full border-none p-0 focus:ring-0 font-bold" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Address') }}</label>
                        <textarea name="consignee_address" rows="2" class="w-full border-none p-0 focus:ring-0 resize-none">{{ old('consignee_address') }}</textarea>
                    </div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('City/State/Zip') }}</label><input
                            name="consignee_city_zip" value="{{ old('consignee_city_zip') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Country') }}</label><input
                            name="consignee_country" value="{{ old('consignee_country') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Phone/Fax') }}</label><input
                            name="consignee_phone" value="{{ old('consignee_phone') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div><label class="block text-gray-500 uppercase text-[9px]">{{ __('Contact Person') }}</label><input
                            name="consignee_contact" value="{{ old('consignee_contact') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
            </div>

            <div class="grid grid-cols-12 border-b border-black h-36">
                <div class="col-span-8 grid grid-cols-4 grid-rows-2 border-r border-black h-full">
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Tax ID No (EIN)') }}</label><input
                            name="reference_tax_id" value="{{ old('reference_tax_id') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Total Gross Weight') }}</label><input
                            name="total_gross_weight" value="{{ old('total_gross_weight') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Transportation') }}</label><input
                            name="transportation" value="{{ old('transportation') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-b border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Consignee Tax ID No (EIN)') }}</label><input
                            name="consignee_tax_id" value="{{ old('consignee_tax_id') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>

                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Other') }}</label><input
                            name="other_info" value="{{ old('other_info') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Total # of Pieces') }}</label><input
                            name="total_pieces" value="{{ old('total_pieces') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="border-r border-black p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('AWB/BL#') }}</label><input
                            name="awb_bl_number" value="{{ old('awb_bl_number') }}"
                            class="w-full border-none p-0 focus:ring-0" /></div>
                    <div class="p-1"><label
                            class="block text-[8px] font-bold uppercase">{{ __('Currency') }}</label><input name="currency"
                            value="{{ old('currency', 'USD') }}" class="w-full border-none p-0 focus:ring-0" /></div>
                </div>
                <div class="col-span-4 p-2 h-full">
                    <label class="block text-[9px] font-bold uppercase mb-1">{{ __('Terms of Sale') }}</label>
                    <textarea name="terms_of_sale" class="w-full border-none p-0 focus:ring-0 resize-none h-24">{{ old('terms_of_sale') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4 mb-2 print:hidden">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-700">{{ __('Commodities') }}</h2>
                <button type="button" onclick="addCommodityRow()"
                    class="px-3 py-1 bg-blue-600 text-white rounded text-xs">{{ __('Add Item') }}</button>
            </div>

            <div id="commodity-rows" class="space-y-2">
                <div class="commodity-row grid grid-cols-12 border-b border-black divide-x divide-black bg-white min-h-[300px]">
                    <div class="col-span-3 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('Commodity Description') }}
                        </div>
                        <div class="p-2 grow flex">
                            <textarea name="commodity_description[]"
                                class="w-full h-full border-none p-0 focus:ring-0 resize-none text-[11px] leading-tight bg-transparent">{{ old('commodity_description.0') }}</textarea>
                        </div>
                    </div>

                    <div class="col-span-1 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('HS') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="hs_code[]" value="{{ old('hs_code.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-2 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[8px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center leading-none">
                            {{ __('Country of Manufacture') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="country_of_manufacture[]" value="{{ old('country_of_manufacture.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-1 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('QTY') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="quantity[]" value="{{ old('quantity.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-1 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('UOM') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="uom[]" value="{{ old('uom.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-2 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('Unit Price') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="unit_price[]" value="{{ old('unit_price.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-2 flex flex-col h-full">
                        <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                            {{ __('Total Amount') }}
                        </div>
                        <div class="p-2 grow flex items-start">
                            <input name="line_total[]" value="{{ old('line_total.0') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] font-bold bg-transparent" />
                        </div>
                    </div>

                    <div class="col-span-12 p-2 text-right print:hidden">
                        <button type="button" class="remove-commodity-row px-2 py-1 bg-red-600 text-white text-xs rounded disabled:opacity-40"
                            onclick="removeCommodityRow(this)">{{ __('Remove') }}</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 h-44 mt-4 border-t border-black">
                <div class="col-span-7 p-4 text-[9px] italic border-r border-black leading-tight text-gray-700">
                    {{ __('These commodities, technologies, or software were exported from the United States in accordance with export administration regulations. Diversions contrary to United States law prohibited. We certify that this commercial invoice is true and correct.') }}
                </div>
                <div class="col-span-5 flex flex-col border-l border-black">
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div class="col-span-2 bg-[#f1eeea] border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Subtotal') }}</div>
                        <div class="p-2 flex items-center"><input name="subtotal_amount"
                                value="{{ old('subtotal_amount') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div class="col-span-2 border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Freight Cost') }}</div>
                        <div class="p-2 flex items-center"><input name="freight_cost"
                                value="{{ old('freight_cost') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 border-b border-black h-1/4">
                        <div class="col-span-2 bg-[#f1eeea] border-r border-black p-2 font-bold uppercase flex items-center">
                            {{ __('Insurance Cost') }}</div>
                        <div class="p-2 flex items-center"><input name="insurance_cost"
                                value="{{ old('insurance_cost') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right" /></div>
                    </div>
                    <div class="grid grid-cols-3 h-1/4 bg-[#f1eeea]">
                        <div class="col-span-2 border-r border-black p-2 font-black uppercase text-[12px] flex items-center">
                            {{ __('Total Invoice Value') }}</div>
                        <div class="p-2 flex items-center"><input name="total_invoice_value"
                                value="{{ old('total_invoice_value') }}"
                                class="w-full border-none p-0 focus:ring-0 text-right font-black text-sm" /></div>
                    </div>
                </div>
            </div>

            <div class="border-t border-black p-3">
                <p class="mb-4 text-[10px] font-medium">
                    {{ __('I/we hereby certify that the information on this invoice is true and correct and that the contents of this shipment are as stated above.') }}
                </p>

                <div class="grid grid-cols-3 border border-black h-44">
                    <div class="border-r border-black p-2">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Name') }}</label>
                        <input name="signer_name" value="{{ old('signer_name') }}" class="w-full border-none p-0 focus:ring-0 text-[11px] font-bold" />
                    </div>
                    <div class="border-r border-black p-2 flex flex-col">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Signature') }}</label>
                        <canvas id="signatureCanvas" width="400" height="120" class="border border-gray-300 rounded-lg bg-white w-full"></canvas>
                        <div class="mt-2 flex gap-2">
                            <button type="button" id="clearSignature" class="px-3 py-1 bg-gray-200 rounded text-xs">{{ __('Clear') }}</button>
                            <button type="button" id="saveSignature" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">{{ __('Save') }}</button>
                        </div>
                        <input type="hidden" name="signature_data" id="signature_data" value="{{ old('signature_data') }}">
                        <div id="signature_preview" class="mt-2"></div>
                    </div>
                    <div class="p-2">
                        <label class="block text-[8px] font-bold uppercase text-gray-500 mb-1">{{ __('Date') }}</label>
                        <input type="date" name="signature_date" value="{{ old('signature_date') }}" class="w-full border-none p-0 focus:ring-0 text-[11px]" />
                    </div>
                </div>
            </div>

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

    <template id="commodity-row-template">
        <div class="commodity-row grid grid-cols-12 border-b border-black divide-x divide-black bg-white min-h-[300px]">
            <div class="col-span-3 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('Commodity Description') }}
                </div>
                <div class="p-2 grow flex">
                    <textarea name="commodity_description[]" class="w-full h-full border-none p-0 focus:ring-0 resize-none text-[11px] leading-tight bg-transparent"></textarea>
                </div>
            </div>
            <div class="col-span-1 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('HS') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="hs_code[]" class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                </div>
            </div>
            <div class="col-span-2 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[8px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center leading-none">
                    {{ __('Country of Manufacture') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="country_of_manufacture[]" class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                </div>
            </div>
            <div class="col-span-1 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('QTY') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="quantity[]" class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                </div>
            </div>
            <div class="col-span-1 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('UOM') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="uom[]" class="w-full border-none p-0 focus:ring-0 text-center text-[11px] bg-transparent" />
                </div>
            </div>
            <div class="col-span-2 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('Unit Price') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="unit_price[]" class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] bg-transparent" />
                </div>
            </div>
            <div class="col-span-2 flex flex-col h-full">
                <div class="bg-[#f1eeea] p-2 border-b border-black text-[9px] font-bold uppercase text-gray-700 h-10 flex items-center justify-center text-center">
                    {{ __('Total Amount') }}
                </div>
                <div class="p-2 grow flex items-start">
                    <input name="line_total[]" class="w-full border-none p-0 focus:ring-0 text-right px-2 text-[11px] font-bold bg-transparent" />
                </div>
            </div>
            <div class="col-span-12 p-2 text-right print:hidden">
                <button type="button" class="remove-commodity-row px-2 py-1 bg-red-600 text-white text-xs rounded"
                    onclick="removeCommodityRow(this)">{{ __('Remove') }}</button>
            </div>
        </div>
    </template>

    <script>
        function addCommodityRow() {
            const template = document.getElementById('commodity-row-template');
            const row = template.content.cloneNode(true);
            document.getElementById('commodity-rows').appendChild(row);
            updateCommodityButtons();
        }

        function removeCommodityRow(button) {
            const rows = document.querySelectorAll('#commodity-rows .commodity-row');
            if (rows.length <= 1) {
                return;
            }
            button.closest('.commodity-row').remove();
            updateCommodityButtons();
        }

        function updateCommodityButtons() {
            const rows = document.querySelectorAll('#commodity-rows .commodity-row');
            rows.forEach(row => {
                const removeBtn = row.querySelector('.remove-commodity-row');
                if (removeBtn) {
                    removeBtn.disabled = rows.length <= 1;
                }
            });
        }

        document.addEventListener('DOMContentLoaded', updateCommodityButtons);

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

            function clearCanvas() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }

            document.getElementById('clearSignature').addEventListener('click', function () {
                clearCanvas();
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
            }

            if (form) {
                form.addEventListener('submit', function () {
                    if (hasDrawn && !signatureInput.value) {
                        signatureInput.value = canvas.toDataURL('image/png');
                        renderPreview(signatureInput.value);
                    }
                });
            }
        });
    </script>
@endsection
