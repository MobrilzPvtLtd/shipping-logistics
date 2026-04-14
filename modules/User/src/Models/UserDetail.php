<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'importer_name',
        'id_type',
        'id_ein',
        'id_ssn',
        'id_cbp',
        'request_cbp_number',
        'cbp_form_data',
        'existing_cbp_number',
        'company_types',
        'entries_year',
        'use_cases',
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
        'mailing_address_types',
        'mailing_address_other',
        'same_as_mailing',
        'physical_street_1',
        'physical_street_2',
        'physical_city',
        'physical_state',
        'physical_zip',
        'physical_country',
        'physical_address_types',
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
        'related_businesses',
        'bank_name',
        'bank_routing',
        'bank_city',
        'bank_state',
        'bank_country',
        'inc_locator_id',
        'inc_ref_number',
        'officers',
        'cert_name',
        'cert_title',
        'cert_date',
        'cert_phone',
        'broker_name',
        'broker_phone',
        'signature_data',
        'privacy_agreed',
        'existing_compliance_documents',
        'completed_at',
    ];

    protected $casts = [
        'request_cbp_number' => 'boolean',
        'same_as_mailing' => 'boolean',
        'privacy_agreed' => 'boolean',
        'cbp_form_data' => 'array',
        'company_types' => 'array',
        'use_cases' => 'array',
        'mailing_address_types' => 'array',
        'physical_address_types' => 'array',
        'related_businesses' => 'array',
        'officers' => 'array',
        'existing_compliance_documents' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
