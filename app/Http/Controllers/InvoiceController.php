<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    protected function canAccessShipmentInvoices(Shipment $shipment): bool
    {
        return Auth::user()->can('view-shipments') && Auth::user()->can('view-invoices') && (
            $shipment->user_id === Auth::id() ||
            Auth::user()->hasRole(['Super Admin', 'Admin', 'Warehouse Staff'])
        );
    }

    public function index(Shipment $shipment): View
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);

        $invoices = $shipment->invoices()->latest()->get();

        return view('invoices.index', compact('shipment', 'invoices'));
    }

    public function create(Shipment $shipment): View
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);

        return view('invoices.create', compact('shipment'));
    }

    public function store(Request $request, Shipment $shipment): RedirectResponse
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);

        $data = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'exporter_name' => 'nullable|string|max:255',
            'exporter_address' => 'nullable|string|max:1000',
            'exporter_city_zip' => 'nullable|string|max:255',
            'exporter_country' => 'nullable|string|max:255',
            'exporter_phone' => 'nullable|string|max:100',
            'consignee_name' => 'nullable|string|max:255',
            'consignee_address' => 'nullable|string|max:1000',
            'consignee_city_zip' => 'nullable|string|max:255',
            'consignee_country' => 'nullable|string|max:255',
            'consignee_phone' => 'nullable|string|max:100',
            'consignee_contact' => 'nullable|string|max:255',
            'consignee_tax_id' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'reference_tax_id' => 'nullable|string|max:255',
            'total_gross_weight' => 'nullable|numeric|min:0',
            'transportation' => 'nullable|string|max:255',
            'terms_of_sale' => 'nullable|string|max:255',
            'other_info' => 'nullable|string|max:500',
            'total_pieces' => 'nullable|integer|min:0',
            'awb_bl_number' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'subtotal_amount' => 'nullable|numeric|min:0',
            'freight_cost' => 'nullable|numeric|min:0',
            'insurance_cost' => 'nullable|numeric|min:0',
            'total_invoice_value' => 'nullable|numeric|min:0',
            'commodity_description' => 'nullable|string|max:2000',
            'hs_code' => 'nullable|string|max:255',
            'country_of_manufacture' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'uom' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
            'line_total' => 'nullable|numeric|min:0',
            'signer_name' => 'nullable|string|max:255',
            'signature_date' => 'nullable|date',
            'signature_data' => 'nullable|string',
            'invoice_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,tiff|max:10240',
        ]);

        if ($request->hasFile('invoice_file')) {
            $file = $request->file('invoice_file');
            $path = $file->store('invoices', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $data['shipment_id'] = $shipment->id;

        Invoice::create($data);

        return redirect()->route('shipments.invoices.index', $shipment)->with('success', __('Invoice uploaded successfully.'));
    }

    public function edit(Shipment $shipment, Invoice $invoice): View
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);
        abort_unless($invoice->shipment_id === $shipment->id, 404);

        return view('invoices.create', compact('shipment', 'invoice'));
    }

    public function update(Request $request, Shipment $shipment, Invoice $invoice): RedirectResponse
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);
        abort_unless($invoice->shipment_id === $shipment->id, 404);

        $data = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'exporter_name' => 'nullable|string|max:255',
            'exporter_address' => 'nullable|string|max:1000',
            'exporter_city_zip' => 'nullable|string|max:255',
            'exporter_country' => 'nullable|string|max:255',
            'exporter_phone' => 'nullable|string|max:100',
            'consignee_name' => 'nullable|string|max:255',
            'consignee_address' => 'nullable|string|max:1000',
            'consignee_city_zip' => 'nullable|string|max:255',
            'consignee_country' => 'nullable|string|max:255',
            'consignee_phone' => 'nullable|string|max:100',
            'consignee_contact' => 'nullable|string|max:255',
            'consignee_tax_id' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'reference_tax_id' => 'nullable|string|max:255',
            'total_gross_weight' => 'nullable|numeric|min:0',
            'transportation' => 'nullable|string|max:255',
            'terms_of_sale' => 'nullable|string|max:255',
            'other_info' => 'nullable|string|max:500',
            'total_pieces' => 'nullable|integer|min:0',
            'awb_bl_number' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'subtotal_amount' => 'nullable|numeric|min:0',
            'freight_cost' => 'nullable|numeric|min:0',
            'insurance_cost' => 'nullable|numeric|min:0',
            'total_invoice_value' => 'nullable|numeric|min:0',
            'commodity_description' => 'nullable|string|max:2000',
            'hs_code' => 'nullable|string|max:255',
            'country_of_manufacture' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'uom' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
            'line_total' => 'nullable|numeric|min:0',
            'signer_name' => 'nullable|string|max:255',
            'signature_date' => 'nullable|date',
            'signature_data' => 'nullable|string',
            'invoice_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,tiff|max:10240',
        ]);

        if ($request->hasFile('invoice_file')) {
            $file = $request->file('invoice_file');
            $path = $file->store('invoices', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $invoice->update($data);

        return redirect()->route('shipments.invoices.index', $shipment)->with('success', __('Invoice updated successfully.'));
    }

    public function download(Shipment $shipment, Invoice $invoice)
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);
        abort_unless($invoice->shipment_id === $shipment->id, 404);

        return Storage::disk('public')->download($invoice->file_path);
    }

    public function destroy(Shipment $shipment, Invoice $invoice): RedirectResponse
    {
        abort_unless($this->canAccessShipmentInvoices($shipment), 403);
        abort_unless($invoice->shipment_id === $shipment->id, 404);

        if ($invoice->file_path && Storage::disk('public')->exists($invoice->file_path)) {
            Storage::disk('public')->delete($invoice->file_path);
        }

        $invoice->delete();

        return redirect()->route('shipments.invoices.index', $shipment)->with('success', __('Invoice deleted successfully.'));
    }
}
