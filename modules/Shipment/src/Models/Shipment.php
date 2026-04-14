<?php

namespace Modules\Shipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_date',
        'invoice_number',
        'invoice_file_path',
        'exporter_name',
        'exporter_address',
        'exporter_city_zip',
        'exporter_country',
        'exporter_phone',
        'contact_person',
        'consignee_name',
        'consignee_address',
        'consignee_city_zip',
        'consignee_country',
        'consignee_phone',
        'consignee_contact',
        'reference_tax_id',
        'total_gross_weight',
        'transportation',
        'consignee_tax_id',
        'other_info',
        'total_pieces',
        'awb_bl_number',
        'currency',
        'terms_of_sale',
        'commodities',
        'subtotal_amount',
        'freight_cost',
        'insurance_cost',
        'total_invoice_value',
        'signer_name',
        'signature_data',
        'signature_date',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'signature_date' => 'date',
        'commodities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }
}
