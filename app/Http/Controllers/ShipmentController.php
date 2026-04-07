<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    protected function canManageShipment(Shipment $shipment): bool
    {
        if (Auth::user()->hasAnyRole(['Warehouse Staff', 'Admin', 'Super Admin'])) {
            return $shipment->status === 'pending';
        }

        return $shipment->user_id === Auth::id() && $shipment->status === 'pending';
    }

    protected function canViewShipment(Shipment $shipment): bool
    {
        return Auth::user()->hasAnyRole(['Warehouse Staff', 'Admin', 'Super Admin']) || $shipment->user_id === Auth::id();
    }

    public function index(): View
    {
        abort_unless(Auth::user()->can('view-shipments'), 403);

        $user = Auth::user();

        if ($user->hasAnyRole(['Warehouse Staff', 'Admin', 'Super Admin'])) {
            $shipments = Shipment::latest()->paginate(10);
        } else {
            $shipments = Shipment::where('user_id', Auth::id())->latest()->paginate(10);
        }

        return view('shipments.index', compact('shipments'));
    }

    protected function processComplianceDocuments(Request $request, array $existing = []): array
    {
        $keys = ['cbp_form_5106', 'power_of_attorney', 'vi_excise_tax_credit_card_form'];
        $documents = [];

        foreach ($keys as $key) {
            $existingDocument = $existing[$key] ?? [];

            if ($request->hasFile("compliance_documents.$key")) {
                $file = $request->file("compliance_documents.$key");
                $path = $file->store('compliance_documents', 'public');

                $documents[$key] = [
                    'path' => $path,
                    'uploaded_at' => now()->format('Y-m-d H:i:s'),
                    'status' => 'uploaded',
                ];
            } elseif (!empty($existingDocument['path'])) {
                $documents[$key] = $existingDocument;
            }
        }

        return $documents;
    }

    public function create(): View
    {
        abort_unless(Auth::user()->can('create-shipments'), 403);

        return view('shipments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(Auth::user()->can('create-shipments'), 403);

        $data = $request->validate([
            'tracking_number' => 'nullable|string|unique:shipments,tracking_number',
            'sender_name' => 'nullable|string|max:255',
            'receiver_name' => 'nullable|string|max:255',
            'origin_address' => 'nullable|string|max:1000',
            'destination_address' => 'nullable|string|max:1000',
            'weight_kg' => 'nullable|numeric|min:0',
            'package_count' => 'nullable|integer|min:1',
            'status' => 'nullable|in:pending,in_transit,delivered,cancelled',
            'description' => 'nullable|string|max:2000',
            'existing_compliance_documents' => 'nullable|array',
            'existing_compliance_documents.*' => 'nullable|string',
            'compliance_documents' => 'nullable|array',
            'compliance_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,tiff|max:10240',

            'importer_name' => 'nullable|string|max:255',
            'id_type' => 'nullable|in:EIN,SSN,CBP,REQUEST_CBP',
            'id_ein' => 'nullable|string|max:255',
            'id_ssn' => 'nullable|string|max:255',
            'id_cbp' => 'nullable|string|max:255',
            'type_div' => 'nullable|boolean',
            'type_aka' => 'nullable|boolean',
            'type_dba' => 'nullable|boolean',
            'dba_name' => 'nullable|string|max:255',
            'request_cbp_number' => 'nullable|boolean',
            'request_cbp_reasons' => 'nullable|array',
            'request_cbp_reasons.*' => 'nullable|string|max:255',
            'existing_cbp_number' => 'nullable|string|max:255',
            'comp_type' => 'nullable|array',
            'entries_year' => 'nullable|string|max:50',
            'use' => 'nullable|array',
            'use.*' => 'nullable|string|max:255',
            'use_other' => 'nullable|string|max:255',
            'prog_code_1' => 'nullable|string|max:255',
            'prog_code_2' => 'nullable|string|max:255',
            'prog_code_3' => 'nullable|string|max:255',
            'prog_code_4' => 'nullable|string|max:255',
            'mailing_street_1' => 'nullable|string|max:255',
            'mailing_street_2' => 'nullable|string|max:255',
            'mailing_city' => 'nullable|string|max:255',
            'mailing_state' => 'nullable|string|max:255',
            'mailing_zip' => 'nullable|string|max:100',
            'mailing_country' => 'nullable|string|max:100',
            'mailing_address_type' => 'nullable|array',
            'mailing_address_type.*' => 'nullable|string|max:255',
            'mailing_address_other' => 'nullable|string|max:255',
            'physical_street_1' => 'nullable|string|max:255',
            'physical_street_2' => 'nullable|string|max:255',
            'physical_city' => 'nullable|string|max:255',
            'physical_state' => 'nullable|string|max:255',
            'physical_zip' => 'nullable|string|max:100',
            'physical_country' => 'nullable|string|max:100',
            'physical_address_type' => 'nullable|array',
            'physical_address_type.*' => 'nullable|string|max:255',
            'physical_address_other' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'phone_ext' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'business_description' => 'nullable|string|max:1000',
            'naics_code' => 'nullable|string|max:100',
            'duns_number' => 'nullable|string|max:255',
            'filer_code' => 'nullable|string|max:255',
            'year_established' => 'nullable|integer',
            'related' => 'nullable|array',
            'bank_name' => 'nullable|string|max:255',
            'bank_routing' => 'nullable|string|max:255',
            'bank_city' => 'nullable|string|max:255',
            'bank_state' => 'nullable|string|max:255',
            'bank_country' => 'nullable|string|max:255',
            'inc_locator_id' => 'nullable|string|max:255',
            'inc_ref_number' => 'nullable|string|max:255',
            'officer' => 'nullable|array',
            'cert_name' => 'nullable|string|max:255',
            'cert_title' => 'nullable|string|max:255',
            'signature_data' => 'nullable|string',
            'cert_phone' => 'nullable|string|max:100',
            'cert_date' => 'nullable|date',
            'broker_name' => 'nullable|string|max:255',
            'broker_phone' => 'nullable|string|max:100',
            'cbp_form_data' => 'nullable|array',
        ]);

        $data['user_id'] = Auth::id();

        // Keep original nested cbp_form_data for flexibility and historical data.
        $data['cbp_form_data'] = $request->input('cbp_form_data', []);
        $data['type_of_action'] = $request->input('cbp_form_data.type_of_action', []);

        $checkboxFields = ['type_div', 'type_aka', 'type_dba', 'request_cbp_number'];
        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field);
        }

        $data['compliance_documents'] = $this->processComplianceDocuments($request);

        if (empty($data['tracking_number'])) {
            $data['tracking_number'] = 'SHIP'. '-' . Shipment::generateTrackingNumber(Auth::user());
        }

        Shipment::create($data);

        return redirect()->route('shipments.index')->with('success', __('Shipment created successfully.'));
    }

    public function edit(Shipment $shipment): View
    {
        abort_unless($this->canManageShipment($shipment), 403);

        // Reuse create UI for edit with prefill
        return view('shipments.create', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment): RedirectResponse
    {
        abort_unless(Auth::user()->can('edit-shipments'), 403);
        abort_unless($this->canManageShipment($shipment), 403);

        $data = $request->validate([
            'tracking_number' => 'nullable|string|unique:shipments,tracking_number,' . $shipment->id,
            'sender_name' => 'nullable|string|max:255',
            'receiver_name' => 'nullable|string|max:255',
            'origin_address' => 'nullable|string|max:1000',
            'destination_address' => 'nullable|string|max:1000',
            'weight_kg' => 'nullable|numeric|min:0',
            'package_count' => 'nullable|integer|min:1',
            'status' => 'nullable|in:pending,in_transit,delivered,cancelled',
            'description' => 'nullable|string|max:2000',
            'existing_compliance_documents' => 'nullable|array',
            'existing_compliance_documents.*' => 'nullable|string',
            'compliance_documents' => 'nullable|array',
            'compliance_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,tiff|max:10240',

            'importer_name' => 'nullable|string|max:255',
            'id_type' => 'nullable|in:EIN,SSN,CBP,REQUEST_CBP',
            'id_ein' => 'nullable|string|max:255',
            'id_ssn' => 'nullable|string|max:255',
            'id_cbp' => 'nullable|string|max:255',
            'type_div' => 'nullable|boolean',
            'type_aka' => 'nullable|boolean',
            'type_dba' => 'nullable|boolean',
            'dba_name' => 'nullable|string|max:255',
            'request_cbp_number' => 'nullable|boolean',
            'request_cbp_reasons' => 'nullable|array',
            'request_cbp_reasons.*' => 'nullable|string|max:255',
            'existing_cbp_number' => 'nullable|string|max:255',
            'comp_type' => 'nullable|array',
            'entries_year' => 'nullable|string|max:50',
            'use' => 'nullable|array',
            'use.*' => 'nullable|string|max:255',
            'use_other' => 'nullable|string|max:255',
            'prog_code_1' => 'nullable|string|max:255',
            'prog_code_2' => 'nullable|string|max:255',
            'prog_code_3' => 'nullable|string|max:255',
            'prog_code_4' => 'nullable|string|max:255',
            'mailing_street_1' => 'nullable|string|max:255',
            'mailing_street_2' => 'nullable|string|max:255',
            'mailing_city' => 'nullable|string|max:255',
            'mailing_state' => 'nullable|string|max:255',
            'mailing_zip' => 'nullable|string|max:100',
            'mailing_country' => 'nullable|string|max:100',
            'mailing_address_type' => 'nullable|array',
            'mailing_address_type.*' => 'nullable|string|max:255',
            'mailing_address_other' => 'nullable|string|max:255',
            'physical_street_1' => 'nullable|string|max:255',
            'physical_street_2' => 'nullable|string|max:255',
            'physical_city' => 'nullable|string|max:255',
            'physical_state' => 'nullable|string|max:255',
            'physical_zip' => 'nullable|string|max:100',
            'physical_country' => 'nullable|string|max:100',
            'physical_address_type' => 'nullable|array',
            'physical_address_type.*' => 'nullable|string|max:255',
            'physical_address_other' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'phone_ext' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'business_description' => 'nullable|string|max:1000',
            'naics_code' => 'nullable|string|max:100',
            'duns_number' => 'nullable|string|max:255',
            'filer_code' => 'nullable|string|max:255',
            'year_established' => 'nullable|integer',
            'related' => 'nullable|array',
            'bank_name' => 'nullable|string|max:255',
            'bank_routing' => 'nullable|string|max:255',
            'bank_city' => 'nullable|string|max:255',
            'bank_state' => 'nullable|string|max:255',
            'bank_country' => 'nullable|string|max:255',
            'inc_locator_id' => 'nullable|string|max:255',
            'inc_ref_number' => 'nullable|string|max:255',
            'officer' => 'nullable|array',
            'cert_name' => 'nullable|string|max:255',
            'cert_title' => 'nullable|string|max:255',
            'signature_data' => 'nullable|string',
            'cert_phone' => 'nullable|string|max:100',
            'cert_date' => 'nullable|date',
            'broker_name' => 'nullable|string|max:255',
            'broker_phone' => 'nullable|string|max:100',
            'cbp_form_data' => 'nullable|array',
        ]);

        $data['user_id'] = Auth::id();
        $data['cbp_form_data'] = $request->input('cbp_form_data', []);
        $data['type_of_action'] = $request->input('cbp_form_data.type_of_action', []);

        $checkboxFields = ['type_div', 'type_aka', 'type_dba', 'request_cbp_number'];
        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field);
        }

        $data['compliance_documents'] = $this->processComplianceDocuments($request, $shipment->compliance_documents ?? []);

        $shipment->update($data);

        return redirect()->route('shipments.index')->with('success', __('Shipment updated successfully.'));
    }

    public function destroy(Shipment $shipment): RedirectResponse
    {
        abort_unless(Auth::user()->can('delete-shipments'), 403);
        abort_unless($this->canManageShipment($shipment), 403);

        $shipment->delete();

        return redirect()->route('shipments.index')->with('success', __('Shipment deleted successfully.'));
    }
}
