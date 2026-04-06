<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'invoice_number',
        'invoice_date',
        'exporter_name',
        'exporter_address',
        'exporter_city_zip',
        'exporter_country',
        'exporter_phone',
        'consignee_name',
        'consignee_address',
        'consignee_city_zip',
        'consignee_country',
        'consignee_phone',
        'consignee_contact',
        'consignee_tax_id',
        'contact_person',
        'reference_tax_id',
        'total_gross_weight',
        'transportation',
        'terms_of_sale',
        'other_info',
        'total_pieces',
        'awb_bl_number',
        'currency',
        'subtotal_amount',
        'freight_cost',
        'insurance_cost',
        'total_invoice_value',
        'commodity_description',
        'hs_code',
        'country_of_manufacture',
        'quantity',
        'uom',
        'unit_price',
        'line_total',
        'signer_name',
        'signature_date',
        'signature_data',
        'file_path',
        'file_type',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'signature_date' => 'date',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
