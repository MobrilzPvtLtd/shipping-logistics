<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserDetailsController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        if ($user->detail && $user->detail->completed_at) {
            return redirect()->route('dashboard');
        }

        return view('auth::livewire.user-details', [
            'detail' => $user->detail,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        $request->validate([
            'importer_name' => ['required', 'string', 'max:255'],
            'id_type' => ['required', 'string', 'max:50'],
            'mailing_street_1' => ['required', 'string', 'max:255'],
            'mailing_city' => ['required', 'string', 'max:255'],
            'mailing_state' => ['required', 'string', 'max:255'],
            'mailing_zip' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'cert_name' => ['required', 'string', 'max:255'],
            'cert_title' => ['required', 'string', 'max:255'],
            'cert_date' => ['required', 'date'],
            'privacyAgreed' => ['accepted'],
        ]);

        $detailAttributes = [
            'importer_name' => $request->input('importer_name'),
            'id_type' => $request->input('id_type'),
            'id_ein' => $request->input('id_ein'),
            'id_ssn' => $request->input('id_ssn'),
            'id_cbp' => $request->input('id_cbp'),
            'request_cbp_number' => (bool) $request->input('cbp_form_data.request_cbp_number', false),
            'cbp_form_data' => $request->input('cbp_form_data', []),
            'existing_cbp_number' => $request->input('existing_cbp_number'),
            'company_types' => $request->input('comp_type', []),
            'entries_year' => $request->input('entries_year'),
            'use_cases' => $request->input('use', []),
            'use_other' => $request->input('use_other'),
            'prog_code_1' => $request->input('prog_code_1'),
            'prog_code_2' => $request->input('prog_code_2'),
            'prog_code_3' => $request->input('prog_code_3'),
            'prog_code_4' => $request->input('prog_code_4'),
            'mailing_street_1' => $request->input('mailing_street_1'),
            'mailing_street_2' => $request->input('mailing_street_2'),
            'mailing_city' => $request->input('mailing_city'),
            'mailing_state' => $request->input('mailing_state'),
            'mailing_zip' => $request->input('mailing_zip'),
            'mailing_country' => $request->input('mailing_country'),
            'mailing_address_types' => $request->input('mailing_address_type', []),
            'mailing_address_other' => $request->input('mailing_address_other'),
            'same_as_mailing' => $request->boolean('sameAsMailing'),
            'physical_street_1' => $request->input('physical_street_1'),
            'physical_street_2' => $request->input('physical_street_2'),
            'physical_city' => $request->input('physical_city'),
            'physical_state' => $request->input('physical_state'),
            'physical_zip' => $request->input('physical_zip'),
            'physical_country' => $request->input('physical_country'),
            'physical_address_types' => $request->input('physical_address_type', []),
            'physical_address_other' => $request->input('physical_address_other'),
            'phone' => $request->input('phone'),
            'phone_ext' => $request->input('phone_ext'),
            'fax' => $request->input('fax'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'business_description' => $request->input('business_description'),
            'naics_code' => $request->input('naics_code'),
            'duns_number' => $request->input('duns_number'),
            'filer_code' => $request->input('filer_code'),
            'year_established' => $request->input('year_established'),
            'related_businesses' => $request->input('related', []),
            'bank_name' => $request->input('bank_name'),
            'bank_routing' => $request->input('bank_routing'),
            'bank_city' => $request->input('bank_city'),
            'bank_state' => $request->input('bank_state'),
            'bank_country' => $request->input('bank_country'),
            'inc_locator_id' => $request->input('inc_locator_id'),
            'inc_ref_number' => $request->input('inc_ref_number'),
            'officers' => $request->input('officer', []),
            'cert_name' => $request->input('cert_name'),
            'cert_title' => $request->input('cert_title'),
            'cert_date' => $request->input('cert_date'),
            'cert_phone' => $request->input('cert_phone'),
            'broker_name' => $request->input('broker_name'),
            'broker_phone' => $request->input('broker_phone'),
            'signature_data' => $request->input('signature_data'),
            'privacy_agreed' => $request->boolean('privacyAgreed'),
            'completed_at' => now(),
        ];

        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $detailAttributes
        );

        return redirect()->route('dashboard')->with('status', __('Your details have been completed.'));
    }
}
