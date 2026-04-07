<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComplianceDocumentController extends Controller
{
    protected function canViewShipment(Shipment $shipment): bool
    {
        return Auth::user()->can('view-shipments') && Auth::user()->can('view-compliance-documents') && (
            Auth::user()->hasAnyRole(['Warehouse Staff', 'Admin', 'Super Admin']) ||
            $shipment->user_id === Auth::id()
        );
    }

    public function index(Shipment $shipment): View
    {
        abort_unless($this->canViewShipment($shipment), 403);

        $documents = $shipment->compliance_documents ?? [];

        return view('shipments.compliance-documents', compact('shipment', 'documents'));
    }

    public function download(Shipment $shipment, string $key)
    {
        abort_unless($this->canViewShipment($shipment), 403);

        $documents = $shipment->compliance_documents ?? [];
        $document = $documents[$key] ?? null;

        abort_unless($document && !empty($document['path']) && Storage::disk('public')->exists($document['path']), 404);

        return Storage::disk('public')->download($document['path']);
    }
}
