<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Shipment\Models\Shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view-shipments'), 403);

        $query = Shipment::query();

        if (! auth()->user()->hasRole(['Super Admin', 'Admin', 'Warehouse Staff'])) {
            $query->where('user_id', Auth::id());
        }

        $shipments = $query->latest()->paginate(10);

        return view('shipment::index', compact('shipments'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create-shipments'), 403);

        return view('shipment::create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create-shipments'), 403);

        $validated = $request->validate([
            'invoice_date' => ['required', 'date'],
            'invoice_number' => ['nullable', 'string', 'max:255'],
            'invoice_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,tiff'],
            'exporter_name' => ['nullable', 'string', 'max:255'],
            'exporter_address' => ['nullable', 'string'],
            'exporter_city_zip' => ['nullable', 'string', 'max:255'],
            'exporter_country' => ['nullable', 'string', 'max:255'],
            'exporter_phone' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'consignee_name' => ['nullable', 'string', 'max:255'],
            'consignee_address' => ['nullable', 'string'],
            'consignee_city_zip' => ['nullable', 'string', 'max:255'],
            'consignee_country' => ['nullable', 'string', 'max:255'],
            'consignee_phone' => ['nullable', 'string', 'max:255'],
            'consignee_contact' => ['nullable', 'string', 'max:255'],
            'reference_tax_id' => ['nullable', 'string', 'max:255'],
            'total_gross_weight' => ['nullable', 'string', 'max:255'],
            'transportation' => ['nullable', 'string', 'max:255'],
            'consignee_tax_id' => ['nullable', 'string', 'max:255'],
            'other_info' => ['nullable', 'string', 'max:255'],
            'total_pieces' => ['nullable', 'string', 'max:255'],
            'awb_bl_number' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'max:10'],
            'terms_of_sale' => ['nullable', 'string'],
            'commodity_description' => ['required', 'array', 'min:1'],
            'commodity_description.*' => ['required', 'string'],
            'hs_code' => ['nullable', 'array'],
            'hs_code.*' => ['nullable', 'string', 'max:255'],
            'country_of_manufacture' => ['nullable', 'array'],
            'country_of_manufacture.*' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'array'],
            'quantity.*' => ['nullable', 'string', 'max:255'],
            'uom' => ['nullable', 'array'],
            'uom.*' => ['nullable', 'string', 'max:255'],
            'unit_price' => ['nullable', 'array'],
            'unit_price.*' => ['nullable', 'string', 'max:255'],
            'line_total' => ['nullable', 'array'],
            'line_total.*' => ['nullable', 'string', 'max:255'],
            'subtotal_amount' => ['nullable', 'string', 'max:255'],
            'freight_cost' => ['nullable', 'string', 'max:255'],
            'insurance_cost' => ['nullable', 'string', 'max:255'],
            'total_invoice_value' => ['nullable', 'string', 'max:255'],
            'signer_name' => ['nullable', 'string', 'max:255'],
            'signature_data' => ['nullable', 'string'],
            'signature_date' => ['nullable', 'date'],
        ]);

        $commodities = [];
        foreach ($validated['commodity_description'] as $index => $description) {
            if (trim($description) === '') {
                continue;
            }

            $commodities[] = [
                'commodity_description' => $description,
                'hs_code' => $validated['hs_code'][$index] ?? null,
                'country_of_manufacture' => $validated['country_of_manufacture'][$index] ?? null,
                'quantity' => $validated['quantity'][$index] ?? null,
                'uom' => $validated['uom'][$index] ?? null,
                'unit_price' => $validated['unit_price'][$index] ?? null,
                'line_total' => $validated['line_total'][$index] ?? null,
            ];
        }

        if (empty($commodities)) {
            return back()->withInput()->withErrors(['commodity_description' => 'At least one commodity row is required.']);
        }

        $path = null;
        if ($request->hasFile('invoice_file')) {
            $path = $request->file('invoice_file')->store('shipments/invoices', 'public');
        }

        $shipment = Shipment::create([
            'user_id' => Auth::id(),
            'invoice_date' => $validated['invoice_date'],
            'invoice_number' => $validated['invoice_number'] ?? null,
            'invoice_file_path' => $path,
            'exporter_name' => $validated['exporter_name'] ?? null,
            'exporter_address' => $validated['exporter_address'] ?? null,
            'exporter_city_zip' => $validated['exporter_city_zip'] ?? null,
            'exporter_country' => $validated['exporter_country'] ?? null,
            'exporter_phone' => $validated['exporter_phone'] ?? null,
            'contact_person' => $validated['contact_person'] ?? null,
            'consignee_name' => $validated['consignee_name'] ?? null,
            'consignee_address' => $validated['consignee_address'] ?? null,
            'consignee_city_zip' => $validated['consignee_city_zip'] ?? null,
            'consignee_country' => $validated['consignee_country'] ?? null,
            'consignee_phone' => $validated['consignee_phone'] ?? null,
            'consignee_contact' => $validated['consignee_contact'] ?? null,
            'reference_tax_id' => $validated['reference_tax_id'] ?? null,
            'total_gross_weight' => $validated['total_gross_weight'] ?? null,
            'transportation' => $validated['transportation'] ?? null,
            'consignee_tax_id' => $validated['consignee_tax_id'] ?? null,
            'other_info' => $validated['other_info'] ?? null,
            'total_pieces' => $validated['total_pieces'] ?? null,
            'awb_bl_number' => $validated['awb_bl_number'] ?? null,
            'currency' => $validated['currency'] ?? null,
            'terms_of_sale' => $validated['terms_of_sale'] ?? null,
            'commodities' => $commodities,
            'subtotal_amount' => $validated['subtotal_amount'] ?? null,
            'freight_cost' => $validated['freight_cost'] ?? null,
            'insurance_cost' => $validated['insurance_cost'] ?? null,
            'total_invoice_value' => $validated['total_invoice_value'] ?? null,
            'signer_name' => $validated['signer_name'] ?? null,
            'signature_data' => $validated['signature_data'] ?? null,
            'signature_date' => $validated['signature_date'] ?? null,
        ]);

        return redirect()->route('shipments.show', $shipment)->with('status', 'Shipment created successfully.');
    }

    public function show(Shipment $shipment)
    {
        abort_unless(auth()->user()->can('view-shipments'), 403);

        if (! auth()->user()->hasRole(['Super Admin', 'Admin', 'Warehouse Staff']) && $shipment->user_id !== Auth::id()) {
            abort(403);
        }

        $shipment->load('packages');

        return view('shipment::show', compact('shipment'));
    }
}
