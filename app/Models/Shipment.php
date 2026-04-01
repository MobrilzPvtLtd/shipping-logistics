<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_number',
        'sender_name',
        'receiver_name',
        'origin_address',
        'destination_address',
        'weight_kg',
        'package_count',
        'status',
        'description',
        'cbp_form_data',
        'importer_name',
        'id_type',
        'id_ein',
        'id_ssn',
        'id_cbp',
        'type_div',
        'type_aka',
        'type_dba',
        'type_of_action',
        'dba_name',
        'request_cbp_number',
        'request_cbp_reasons',
        'existing_cbp_number',
        'comp_type',
        'entries_year',
        'use',
        'use_other',
        'prog_code_1',
        'prog_code_2',
        'prog_code_3',
        'prog_code_4',
        'mailing_street_1',
        'mailing_street_2',
        'mailing_city',
        'mailing_state',
        'mailing_zip',
        'mailing_country',
        'mailing_address_type',
        'mailing_address_other',
        'physical_street_1',
        'physical_street_2',
        'physical_city',
        'physical_state',
        'physical_zip',
        'physical_country',
        'physical_address_type',
        'physical_address_other',
        'phone',
        'phone_ext',
        'fax',
        'email',
        'website',
        'business_description',
        'naics_code',
        'duns_number',
        'filer_code',
        'year_established',
        'related',
        'bank_name',
        'bank_routing',
        'bank_city',
        'bank_state',
        'bank_country',
        'inc_locator_id',
        'inc_ref_number',
        'officer',
        'cert_name',
        'cert_title',
        'signature_data',
        'cert_phone',
        'cert_date',
        'broker_name',
        'broker_phone',
    ];

    protected $casts = [
        'cbp_form_data' => 'array',
        'weight_kg' => 'decimal:2',
        'request_cbp_reasons' => 'array',
        'type_of_action' => 'array',
        'comp_type' => 'array',
        'mailing_address_type' => 'array',
        'physical_address_type' => 'array',
        'use' => 'array',
        'related' => 'array',
        'officer' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
