@extends('core::layouts.app')

@section('content')
    @php
        $detail = $detail ?? null;
        $savedTypeOfAction = [];

        if (! empty(data_get($detail, 'cbp_form_data.type_of_action'))) {
            $savedTypeOfAction = data_get($detail, 'cbp_form_data.type_of_action');
        }

        $typeOfAction = old('cbp_form_data.type_of_action', $savedTypeOfAction ?? []);
        if (! is_array($typeOfAction)) {
            $typeOfAction = (array) $typeOfAction;
        }

        $initialStep = old('step', 1);
        $initialSameAsMailing = old('sameAsMailing', data_get($detail, 'same_as_mailing', false));
        $initialIdType = old('id_type', optional($detail)->id_type ?? 'EIN');
        $initialRequestCbp = old('cbp_form_data.request_cbp_number', optional($detail)->request_cbp_number ?? false);
        $initialPrivacyAgreed = old('privacyAgreed', false);
    @endphp

    <script>
        function userDetailsForm() {
            return {
                step: Number(@json($initialStep)),
                sameAsMailing: @json($initialSameAsMailing),
                idType: @json($initialIdType),
                requestCbp: @json($initialRequestCbp),
                privacyAgreed: @json($initialPrivacyAgreed),
                formErrors: [],
                stepErrors: [],

                validateStep() {
                    this.formErrors = [];
                    this.stepErrors = [];

                    if (this.step === 1) {
                        if (!document.querySelector('[name="importer_name"]')?.value) {
                            this.formErrors.push('Importer name is required.');
                            this.stepErrors.push('Importer name is required.');
                        }
                        if (!this.idType) {
                            this.formErrors.push('ID type is required.');
                            this.stepErrors.push('ID type is required.');
                        }
                    }

                    if (this.step === 2) {
                        if (!document.querySelector('[name="mailing_street_1"]')?.value) {
                            this.formErrors.push('Mailing street 1 is required.');
                            this.stepErrors.push('Mailing street 1 is required.');
                        }
                        if (!document.querySelector('[name="mailing_city"]')?.value) {
                            this.formErrors.push('Mailing city is required.');
                            this.stepErrors.push('Mailing city is required.');
                        }
                        if (!document.querySelector('[name="mailing_state"]')?.value) {
                            this.formErrors.push('Mailing state is required.');
                            this.stepErrors.push('Mailing state is required.');
                        }
                        if (!document.querySelector('[name="mailing_zip"]')?.value) {
                            this.formErrors.push('Mailing ZIP is required.');
                            this.stepErrors.push('Mailing ZIP is required.');
                        }
                        if (!document.querySelector('[name="phone"]')?.value) {
                            this.formErrors.push('Phone is required.');
                            this.stepErrors.push('Phone is required.');
                        }
                        if (!document.querySelector('[name="email"]')?.value) {
                            this.formErrors.push('Email is required.');
                            this.stepErrors.push('Email is required.');
                        }
                    }

                    if (this.step === 4) {
                        if (!document.querySelector('[name="cert_name"]')?.value) {
                            this.formErrors.push('Certification name is required.');
                            this.stepErrors.push('Certification name is required.');
                        }
                        if (!document.querySelector('[name="cert_title"]')?.value) {
                            this.formErrors.push('Certification title is required.');
                            this.stepErrors.push('Certification title is required.');
                        }
                        if (!document.querySelector('[name="cert_date"]')?.value) {
                            this.formErrors.push('Certification date is required.');
                            this.stepErrors.push('Certification date is required.');
                        }
                        if (!this.privacyAgreed) {
                            this.formErrors.push('Please agree to the privacy statement before continuing.');
                            this.stepErrors.push('Please agree to the privacy statement before continuing.');
                        }
                    }

                    if (this.step === 5 && !this.privacyAgreed) {
                        this.formErrors.push('Please agree to the privacy statement before submitting.');
                        this.stepErrors.push('Please agree to the privacy statement before submitting.');
                    }

                    if (this.stepErrors.length > 0) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        return false;
                    }

                    return true;
                },

                goNext() {
                    if (this.validateStep()) {
                        this.step = Math.min(5, this.step + 1);
                    }
                },

                submitForm(event) {
                    if (!this.validateStep()) return;
                    const originalStep = this.step;
                    for (let i = 1; i <= 5; i++) {
                        this.step = i;
                        if (!this.validateStep()) {
                            return;
                        }
                    }
                    this.step = originalStep;
                    event.target.submit();
                }
            };
        }
    </script>

    <div x-data="userDetailsForm()" class="max-w-7xl mt-4 mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <template x-if="formErrors.length || stepErrors.length">
            <div class="mb-4 p-3 rounded-lg" :class="formErrors.length ? 'border border-red-400 bg-red-50 text-red-800' : 'border border-yellow-400 bg-yellow-50 text-yellow-800'">
                <p class="font-semibold" x-text="formErrors.length ? '{{ __('Please fix errors before submitting:') }}' : '{{ __('Please fix step errors before continuing:') }}'"></p>
                <ul class="list-disc list-inside text-sm">
                    <template x-for="error in (formErrors.length ? formErrors : stepErrors)" :key="error">
                        <li x-text="error"></li>
                    </template>
                </ul>
            </div>
        </template>

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-400 bg-red-50 p-3 text-sm text-red-800">
                <p class="font-semibold">{{ __('Please fix the following errors:') }}</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('DEPARTMENT OF HOMELAND SECURITY') }}</h1>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('U.S. Customs and Border Protection') }}</h2>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                {{ __('CREATE/UPDATE IMPORTER IDENTITY FORM') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wider">{{ __('19 CFR 24.5') }}</p>
            <p class="text-gray-600 dark:text-gray-400 mt-2 italic text-sm">
                {{ __('As the importer, consignee, or other party listed in block 1, you are responsible for the validity of the information provided in this document. Any Customs Broker or third party who is submitting the information on your behalf is only obligated to convey this information to Customs and Border Protection (CBP). ') }}
            </p>
        </div>


        <div class="text-center mb-6 mt-4">
            <span class="text-red-600 dark:text-red-400 font-semibold">{{ __('All the data elements with a red asterisk are required') }}</span>
        </div>

        <div class="mb-8">
            <div class="flex items-center gap-3">
                <template x-for="i in 5" :key="i">
                    <div class="flex-1">
                        <div :class="step >= i ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'" class="h-2 rounded-full transition-all"></div>
                    </div>
                </template>
            </div>
            <div class="flex justify-between text-xs mt-2 text-gray-600 dark:text-gray-300">
                <span>{{ __('1. Identity & IDs') }}</span>
                <span>{{ __('2. Address & Contact') }}</span>
                <span>{{ __('3. Business Details') }}</span>
                <span>{{ __('4. Privacy & Certification') }}</span>
                <span class="inline-flex items-center gap-1">
                    <span>{{ __('5. Instructions') }}</span>
                    <template x-if="privacyAgreed && step === 5">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                </span>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @php $isEdit = isset($detail); @endphp
        <form method="POST" action="{{ route('user.details.store') }}" class="space-y-6" enctype="multipart/form-data" novalidate @submit.prevent="submitForm($event)">
            @csrf
            <input type="hidden" name="step" :value="step" />

            <div class="border border-gray-300 dark:border-gray-700 rounded-lg p-4 mb-6 bg-gray-50 dark:bg-gray-900">
                <p class="font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ __('TYPE OF ACTION (Mark all applicable)') }}
                </p>
                <div class="flex flex-wrap gap-4 text-sm text-gray-700 dark:text-gray-300">
                    <label class="inline-flex items-center gap-2"><input type="checkbox"
                            name="cbp_form_data[type_of_action][notification_of_id]" value="1"
                            class="rounded text-blue-600" {{ in_array('notification_of_id', array_keys((array) $typeOfAction)) ? 'checked' : '' }}>{{ __('Notification of Identification Number') }}</label>
                    <label class="inline-flex items-center gap-2"><input type="checkbox"
                            name="cbp_form_data[type_of_action][change_of_name]" value="1"
                            class="rounded text-blue-600" {{ in_array('change_of_name', array_keys((array) $typeOfAction)) ? 'checked' : '' }}>{{ __('Change of Name') }}</label>
                    <label class="inline-flex items-center gap-2"><input type="checkbox"
                            name="cbp_form_data[type_of_action][change_of_address]" value="1"
                            class="rounded text-blue-600" {{ in_array('change_of_address', array_keys((array) $typeOfAction)) ? 'checked' : '' }}>{{ __('Change of Address') }}</label>
                </div>
            </div>

            <hr>

            <div x-show="step === 1" class="space-y-6">
                <template x-if="stepErrors.length">
                    <div class="p-3 mb-3 rounded-lg border border-red-400 bg-red-50 text-red-800 text-sm">
                        <ul class="list-disc list-inside">
                            <template x-for="error in stepErrors" :key="error">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </template>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 border-b-2 border-black pb-1 uppercase">
                    1. Name and Identification Number
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-12">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            <span class="text-red-600">*</span>1A. Importer/Business/Private Party Name:
                        </label>
                        <input name="importer_name" required value="{{ old('importer_name', data_get($detail, 'importer_name', data_get($detail, 'form_data.importer_name'))) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-blue-50 dark:bg-gray-900 rounded shadow-sm focus:ring-blue-500" />
                    </div>

                    <div class="md:col-span-12 border-t pt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            <span class="text-red-600">*</span>1B. Internal Revenue Service (IRS) Employer Identification
                            Number (EIN), Social Security Number (SSN), or CBP-Assigned Number:
                        </label>
                        <p class="text-xs font-bold italic mb-2">Number Type: (Select Only One)</p>

                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-4">
                                <label class="inline-flex items-center gap-2 min-w-[250px]">
                                    <input type="radio" x-model="idType" name="id_type" value="EIN"
                                        class="text-blue-600" {{ old('id_type', optional($detail)->id_type ?? 'EIN') === 'EIN' ? 'checked' : '' }} />
                                    <span class="text-sm">IRS Employer Identification Number (EIN)</span>
                                </label>
                                <input x-show="idType === 'EIN'" type="text" name="id_ein" value="{{ old('id_ein', data_get($detail, 'id_ein', data_get($detail, 'form_data.id_ein'))) }}"
                                    class="h-8 border-gray-300 bg-blue-50 w-64 rounded" />
                            </div>
                            <div class="flex flex-wrap items-center gap-4">
                                <label class="inline-flex items-center gap-2 min-w-[250px]">
                                    <input type="radio" x-model="idType" name="id_type" value="SSN"
                                        class="text-blue-600" {{ old('id_type', optional($detail)->id_type ?? 'EIN') === 'SSN' ? 'checked' : '' }} />
                                    <span class="text-sm">Social Security Number (SSN)</span>
                                </label>
                                <input x-show="idType === 'SSN'" type="text" name="id_ssn" value="{{ old('id_ssn', data_get($detail, 'id_ssn', data_get($detail, 'form_data.id_ssn'))) }}"
                                    class="h-8 border-gray-300 bg-blue-50 w-64 rounded" />
                            </div>
                            <div class="flex flex-wrap items-center gap-4">
                                <label class="inline-flex items-center gap-2 min-w-[250px]">
                                    <input type="radio" x-model="idType" name="id_type" value="CBP"
                                        class="text-blue-600" {{ old('id_type', optional($detail)->id_type ?? 'EIN') === 'CBP' ? 'checked' : '' }} />
                                    <span class="text-sm">CBP-Assigned Number</span>
                                </label>
                                <input x-show="idType === 'CBP'" type="text" name="id_cbp" value="{{ old('id_cbp', data_get($detail, 'id_cbp', data_get($detail, 'form_data.id_cbp'))) }}"
                                    class="h-8 border-gray-300 bg-blue-50 w-64 rounded" />
                            </div>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" x-model="idType" name="id_type" value="REQUEST_CBP"
                                    class="text-blue-600" {{ old('id_type', optional($detail)->id_type ?? 'EIN') === 'REQUEST_CBP' ? 'checked' : '' }} />
                                <span class="text-sm">Requesting a CBP-Assigned Number</span>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-4 border-t pt-2 border-r pr-2">
                        <label class="block text-sm font-bold mb-1">1C.</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center text-xs"><input type="checkbox" name="type_div"
                                    class="mr-1" {{ old('type_div', data_get($detail, 'form_data.type_div')) ? 'checked' : '' }}> DIV</label>
                            <label class="inline-flex items-center text-xs"><input type="checkbox" name="type_aka"
                                    class="mr-1" {{ old('type_aka', data_get($detail, 'form_data.type_aka')) ? 'checked' : '' }}> AKA</label>
                            <label class="inline-flex items-center text-xs"><input type="checkbox" name="type_dba"
                                    class="mr-1" {{ old('type_dba', data_get($detail, 'form_data.type_dba')) ? 'checked' : '' }}> DBA</label>
                        </div>
                    </div>
                    <div class="md:col-span-8 border-t pt-2">
                        <label class="block text-sm font-bold">1D. DIV/AKA/DBA Name:</label>
                        <input name="dba_name" value="{{ old('dba_name', data_get($detail, 'dba_name', data_get($detail, 'form_data.dba_name'))) }}" class="mt-1 block w-full border-gray-300 bg-blue-50 rounded h-8" />
                    </div>

                    <div class="md:col-span-12 border-t pt-2 bg-gray-50 dark:bg-gray-800 p-2">
                        <label class="flex items-start gap-2 text-sm font-bold">
                            <input type="checkbox" x-model="requestCbp" name="cbp_form_data[request_cbp_number]"
                                value="1" class="mt-1" {{ old('cbp_form_data.request_cbp_number', optional($detail)->request_cbp_number ?? false) ? 'checked' : '' }} />
                            <span>1E. I wish to be assigned a CBP Number. Check here if requesting a CBP-assigned number and
                                indicate reason(s).</span>
                        </label>

                        <div x-show="requestCbp" class="mt-2 ml-6">
                            <p class="text-xs font-bold underline mb-2">If you marked yes to receive a CBP assigned number,
                                indicate the reasons why. Check all that apply.</p>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-2 text-[10px] leading-tight">
                                <label class="flex gap-1"><input type="checkbox"
                                        name="cbp_form_data[request_cbp_reasons][]" value="has_ssn" {{ in_array('has_ssn', old('cbp_form_data.request_cbp_reasons', data_get($detail, 'cbp_form_data.request_cbp_reasons', []))) ? 'checked' : '' }}> I
                                    have a SSN, but wish to use a CBP-Assigned Number...</label>
                                <label class="flex gap-1"><input type="checkbox"
                                        name="cbp_form_data[request_cbp_reasons][]" value="no_ssn" {{ in_array('no_ssn', old('cbp_form_data.request_cbp_reasons', data_get($detail, 'cbp_form_data.request_cbp_reasons', []))) ? 'checked' : '' }}> I have
                                    no Social Security Number</label>
                                <label class="flex gap-1"><input type="checkbox"
                                        name="cbp_form_data[request_cbp_reasons][]" value="no_irs" {{ in_array('no_irs', old('cbp_form_data.request_cbp_reasons', data_get($detail, 'cbp_form_data.request_cbp_reasons', []))) ? 'checked' : '' }}> I have
                                    no IRS Number</label>
                                <label class="flex gap-1"><input type="checkbox"
                                        name="cbp_form_data[request_cbp_reasons][]" value="not_applied" {{ in_array('not_applied', old('cbp_form_data.request_cbp_reasons', data_get($detail, 'cbp_form_data.request_cbp_reasons', []))) ? 'checked' : '' }}> I
                                    have not applied for an IRS number or SSN</label>
                                <label class="flex gap-1"><input type="checkbox"
                                        name="cbp_form_data[request_cbp_reasons][]" value="non_resident" {{ in_array('non_resident', old('cbp_form_data.request_cbp_reasons', data_get($detail, 'cbp_form_data.request_cbp_reasons', []))) ? 'checked' : '' }}>
                                    I am not a U.S. Resident</label>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-12 border-t pt-2">
                        <label class="block text-sm font-bold">1F. CBP-Assigned Number:</label>
                        <input name="existing_cbp_number"
                            class="mt-1 block w-full md:w-1/2 border-gray-300 bg-blue-50 rounded h-8"
                            value="{{ old('existing_cbp_number', data_get($detail, 'existing_cbp_number', data_get($detail, 'form_data.existing_cbp_number'))) }}" />
                    </div>

                    <div class="md:col-span-12 border-t pt-2">
                        <label class="block text-sm font-bold mb-2">1G. Type of Company:</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-y-2 text-sm">
                            @foreach(['Corporation','Partnership','LLC','SoleProp','Individual','USGov','StateGov','ForeignGov'] as $value)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="comp_type[]" value="{{ $value }}"
                                        class="rounded text-blue-600" {{ in_array($value, old('comp_type', data_get($detail, 'company_types', []))) ? 'checked' : '' }}>
                                    {{ $value === 'SoleProp' ? 'Sole Proprietorship' : ($value === 'USGov' ? 'U.S. Government' : ($value === 'StateGov' ? 'State/Local Government' : ($value === 'ForeignGov' ? 'Foreign Government' : $value))) }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="md:col-span-12 border-t pt-2">
                        <label class="block text-sm font-bold mb-2">1H. If you are an importer, how many entries do you plan on filing in a year? Select from the following:</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            @foreach(['1-4','5-24','25+','none','infrequent'] as $value)
                                <label class="flex items-center gap-2 {{ $value === 'none' ? 'col-span-2' : '' }}">
                                    <input type="radio" name="entries_year" value="{{ $value }}"
                                        {{ old('entries_year', data_get($detail, 'entries_year')) === $value ? 'checked' : '' }}>
                                    @if($value === '1-4') 1-4 per year @elseif($value === '5-24') 5-24 per year @elseif($value === '25+') 25 or more per year @elseif($value === 'none') I do not intend to import. @else infrequent personal shipments @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="md:col-span-12 border-t pt-2">
                        <label class="block text-sm font-bold mb-2">1I. How will the identification number be utilized? Select all options that will apply:</label>
                        <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                            @foreach(['IOR' => 'Importer of Record','Consignee' => 'Consignee/Ultimate Consignee','Drawback' => 'Drawback Claimant','Refunds' => 'Refunds/Bills'] as $value => $label)
                                <label class="flex items-center gap-2"><input type="checkbox" name="use[]" value="{{ $value }}"
                                        class="rounded text-blue-600" {{ in_array($value, old('use', data_get($detail, 'use_cases', []))) ? 'checked' : '' }}>
                                    {{ $label }}</label>
                            @endforeach
                            <div class="flex items-center gap-2 italic">
                                <span class="font-bold">or</span>
                                <label class="flex items-center gap-2">Other <input type="text" name="use_other"
                                        class="border-b border-gray-400 bg-transparent focus:outline-none w-48" value="{{ old('use_other', data_get($detail, 'use_other')) }}" /></label>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-3 border-t border-r pt-2">
                        <label class="block text-[10px] font-bold uppercase">1J. Program Code 1:</label>
                        <input name="prog_code_1" value="{{ old('prog_code_1', data_get($detail, 'prog_code_1')) }}" class="w-full bg-blue-50 border-gray-300 h-8 mt-1" />
                    </div>
                    <div class="md:col-span-3 border-t border-r pt-2">
                        <label class="block text-[10px] font-bold uppercase">1K. Program Code 2:</label>
                        <input name="prog_code_2" value="{{ old('prog_code_2', data_get($detail, 'prog_code_2')) }}" class="w-full bg-blue-50 border-gray-300 h-8 mt-1" />
                    </div>
                    <div class="md:col-span-3 border-t border-r pt-2">
                        <label class="block text-[10px] font-bold uppercase">1L. Program Code 3:</label>
                        <input name="prog_code_3" value="{{ old('prog_code_3', data_get($detail, 'prog_code_3')) }}" class="w-full bg-blue-50 border-gray-300 h-8 mt-1" />
                    </div>
                    <div class="md:col-span-3 border-t pt-2">
                        <label class="block text-[10px] font-bold uppercase">1M. Program Code 4:</label>
                        <input name="prog_code_4" value="{{ old('prog_code_4', data_get($detail, 'prog_code_4')) }}" class="w-full bg-blue-50 border-gray-300 h-8 mt-1" />
                    </div>

                </div>
            </div>

            <div x-show="step === 2" class="space-y-6" x-cloak>
                <template x-if="stepErrors.length">
                    <div class="p-3 mb-3 rounded-lg border border-red-400 bg-red-50 text-red-800 text-sm">
                        <ul class="list-disc list-inside">
                            <template x-for="error in stepErrors" :key="error">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </template>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b pb-2">
                    {{ __('2. Address Information') }}</h2>

                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="font-medium text-sm text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                            {{ __('2A. Mailing Address') }}</h3>
                        <span class="text-red-600 text-xs italic">{{ __('(Each street address line can be no more than 32 characters)') }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('Street Address 1') }}</label>
                            <input name="mailing_street_1" required maxlength="32" value="{{ old('mailing_street_1', data_get($detail, 'mailing_street_1')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Street Address 2') }}</label>
                            <input name="mailing_street_2" maxlength="32" value="{{ old('mailing_street_2', data_get($detail, 'mailing_street_2')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('City') }}</label>
                            <input name="mailing_city" required value="{{ old('mailing_city', data_get($detail, 'mailing_city')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('State/Province') }}</label>
                            <input name="mailing_state" required value="{{ old('mailing_state', data_get($detail, 'mailing_state')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('Zip Code') }}</label>
                            <input name="mailing_zip" required value="{{ old('mailing_zip', data_get($detail, 'mailing_zip')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Country ISO Code') }}</label>
                            <input name="mailing_country" placeholder="e.g. US" value="{{ old('mailing_country', data_get($detail, 'mailing_country')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><span class="text-red-600">*</span>{{ __('Is the address in 2A, a:') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach (['Residence', 'Corporate Office', 'Warehouse', 'Retail Location', 'Office Building', 'Business Service Center', 'Post Office Box'] as $type)
                                <label class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <input type="checkbox" name="mailing_address_type[]" value="{{ $type }}"
                                        class="rounded text-blue-600 mr-2" {{ in_array($type, old('mailing_address_type', data_get($detail, 'mailing_address_types', []))) ? 'checked' : '' }} />
                                    {{ $type }}
                                </label>
                            @endforeach
                            <div class="col-span-2 flex items-center gap-2">
                                <input type="checkbox" name="mailing_address_type[]" value="Other"
                                    class="rounded text-blue-600" {{ in_array('Other', old('mailing_address_type', data_get($detail, 'mailing_address_types', []))) ? 'checked' : '' }} />
                                <span class="text-xs text-gray-600">{{ __('Other:') }}</span>
                                <input name="mailing_address_other" value="{{ old('mailing_address_other', data_get($detail, 'mailing_address_other')) }}"
                                    class="border-b border-gray-300 bg-transparent text-xs focus:ring-0 focus:border-blue-500 w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center px-2">
                    <input type="checkbox" x-model="sameAsMailing" id="sameAsMailing" class="rounded text-blue-600" {{ old('sameAsMailing', data_get($detail, 'same_as_mailing')) ? 'checked' : '' }}>
                    <label for="sameAsMailing" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-400">
                        {{ __('2B. Physical location is same as mailing address') }}
                    </label>
                </div>

                <div x-show="!sameAsMailing" class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg space-y-4" x-transition>
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="font-medium text-sm text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                            {{ __('2B. Physical Location Address') }}</h3>
                        <span class="text-red-600 text-xs italic">{{ __('(Required only if different than mailing address)') }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('Street Address 1') }}</label>
                            <input name="physical_street_1" :required="!sameAsMailing" maxlength="32" value="{{ old('physical_street_1', data_get($detail, 'physical_street_1')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Street Address 2') }}</label>
                            <input name="physical_street_2" maxlength="32" value="{{ old('physical_street_2', data_get($detail, 'physical_street_2')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('City') }}</label>
                            <input name="physical_city" :required="!sameAsMailing" value="{{ old('physical_city', data_get($detail, 'physical_city')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('State/Province') }}</label>
                            <input name="physical_state" :required="!sameAsMailing" value="{{ old('physical_state', data_get($detail, 'physical_state')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Zip Code') }}</label>
                            <input name="physical_zip" :required="!sameAsMailing" value="{{ old('physical_zip', data_get($detail, 'physical_zip')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Country ISO Code') }}</label>
                            <input name="physical_country" value="{{ old('physical_country', data_get($detail, 'physical_country')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><span class="text-red-600">*</span>{{ __('Is the address in 2B, a:') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach (['Residence', 'Corporate Office', 'Warehouse', 'Retail Location', 'Office Building','Business Service Center', 'Post Office Box'] as $type)
                                <label class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <input type="checkbox" name="physical_address_type[]" value="{{ $type }}"
                                        class="rounded text-blue-600 mr-2" {{ in_array($type, old('physical_address_type', data_get($detail, 'physical_address_types', []))) ? 'checked' : '' }} />
                                    {{ $type }}
                                </label>
                            @endforeach
                            <div class="col-span-2 flex items-center gap-2">
                                <input type="checkbox" name="physical_address_type[]" value="Other"
                                    class="rounded text-blue-600" {{ in_array('Other', old('physical_address_type', data_get($detail, 'physical_address_types', []))) ? 'checked' : '' }} />
                                <span class="text-xs text-gray-600">{{ __('Other:') }}</span>
                                <input name="physical_address_other" value="{{ old('physical_address_other', data_get($detail, 'physical_address_other')) }}"
                                    class="border-b border-gray-300 bg-transparent text-xs focus:ring-0 focus:border-blue-500 w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 border-t pt-4">
                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('2C. Phone Number') }}</label>
                        <input type="tel" name="phone" required value="{{ old('phone', data_get($detail, 'phone')) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Extension') }}</label>
                        <input name="phone_ext" value="{{ old('phone_ext', data_get($detail, 'phone_ext')) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>
                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('2D. Fax Number') }}</label>
                        <input type="tel" name="fax" value="{{ old('fax', data_get($detail, 'fax')) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>

                    <div class="md:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-600">*</span>{{ __('2E. Email Address') }}</label>
                        <input type="email" name="email" required value="{{ old('email', data_get($detail, 'email', auth()->user()->email)) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>
                    <div class="md:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('2F. Website') }}</label>
                        <input type="url" name="website" placeholder="https://" value="{{ old('website', data_get($detail, 'website')) }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>
                </div>
            </div>

            <div x-show="step === 3" class="space-y-6" x-cloak>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b pb-2 uppercase tracking-wide">
                    {{ __('3. Company Information') }}
                </h2>

                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3A. Provide a brief business description') }}</label>
                        <textarea name="business_description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm">{{ old('business_description', data_get($detail, 'business_description')) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3B. Provide the 6-digit North American Industry Classification System (NAICS) code for this business:') }}</label>
                            <input name="naics_code" value="{{ old('naics_code', data_get($detail, 'naics_code')) }}" maxlength="6"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3C. Provide the D-U-N-S Number for the Importer:') }}</label>
                            <input name="duns_number" value="{{ old('duns_number', data_get($detail, 'duns_number')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3D. If you are also a broker/self-filer, supply the filer code that will be used when conducting business with CBP:') }}</label>
                            <input name="filer_code" value="{{ old('filer_code', data_get($detail, 'filer_code')) }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3E. Year Established') }}</label>
                        <input type="number" name="year_established" placeholder="YYYY" value="{{ old('year_established', data_get($detail, 'year_established')) }}"
                            class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('3F. List the names and Internal Revenue Service (IRS) Employer Identification Number (EIN), Social Security Number (SSN), or CBP-assigned numbers for current or previous related business entities:') }}</label>
                    <div class="space-y-2">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center border-b border-gray-200 pb-2">
                                <div class="md:col-span-3 flex gap-4 text-xs">
                                    <label class="flex items-center"><input type="checkbox" name="related[{{ $i }}][current]" class="rounded mr-1" {{ old('related.' . $i . '.current', data_get($detail, 'related_businesses.' . $i . '.current')) ? 'checked' : '' }}>{{ __('Current') }}</label>
                                    <label class="flex items-center"><input type="checkbox" name="related[{{ $i }}][previous]" class="rounded mr-1" {{ old('related.' . $i . '.previous', data_get($detail, 'related_businesses.' . $i . '.previous')) ? 'checked' : '' }}>{{ __('Previous') }}</label>
                                </div>
                                <div class="md:col-span-5">
                                    <input name="related[{{ $i }}][name]" placeholder="Name of Business Entity" value="{{ old('related.' . $i . '.name', data_get($detail, 'related_businesses.' . $i . '.name')) }}" class="w-full text-xs border-gray-300 rounded-lg" />
                                </div>
                                <div class="md:col-span-4">
                                    <input name="related[{{ $i }}][id]" placeholder="IRS/SSN/CBP Number" value="{{ old('related.' . $i . '.id', data_get($detail, 'related_businesses.' . $i . '.id')) }}" class="w-full text-xs border-gray-300 rounded-lg" />
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('3G. Primary Banking Institution (Name)') }}</label>
                        <input name="bank_name" value="{{ old('bank_name', data_get($detail, 'bank_name')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">{{ __('Bank Routing Number') }}</label>
                            <input name="bank_routing" value="{{ old('bank_routing', data_get($detail, 'bank_routing')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">{{ __('City') }}</label>
                            <input name="bank_city" value="{{ old('bank_city', data_get($detail, 'bank_city')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">{{ __('State') }}</label>
                            <input name="bank_state" value="{{ old('bank_state', data_get($detail, 'bank_state')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">{{ __('Country ISO Code') }}</label>
                            <input name="bank_country" value="{{ old('bank_country', data_get($detail, 'bank_country')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium">{{ __('3H. Certificate or Articles of Incorporation - (Locater I.D.)') }}</label>
                        <input name="inc_locator_id" value="{{ old('inc_locator_id', data_get($detail, 'inc_locator_id')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium">{{ __('3I. Certificate or Articles of Incorporation – (Reference Number)') }}</label>
                        <input name="inc_ref_number" value="{{ old('inc_ref_number', data_get($detail, 'inc_ref_number')) }}" class="mt-1 block w-full border-gray-300 rounded-lg" />
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-sm font-bold text-blue-800 uppercase mb-2">{{ __('3J. Business Structure / Beneficial Owner / Company Officers') }}</h3>
                        <p class="text-[10px] text-blue-700 leading-tight mb-4 italic">{{ __('The officers listed in this section must have importing and financial business knowledge of the company listed in section 1 of this form and must have legal authority to make decisions on behalf of the company listed in section 1') }}</p>

                        @for ($j = 0; $j < 4; $j++)
                            <div class="mb-6 pb-6 border-b border-blue-200 last:border-0 last:pb-0">
                                <span class="text-xs font-bold text-blue-600 block mb-2 underline">Entry {{ $j + 1 }}</span>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                    <div class="md:col-span-5">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Company Position Title') }}</label>
                                        <input name="officer[{{ $j }}][title]" value="{{ old('officer.' . $j . '.title', data_get($detail, 'officers.' . $j . '.title')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-7">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Name (Last, First, Middle Initial)') }}</label>
                                        <input name="officer[{{ $j }}][name]" value="{{ old('officer.' . $j . '.name', data_get($detail, 'officers.' . $j . '.name')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>

                                    <div class="md:col-span-4">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Direct Phone Number') }}</label>
                                        <input name="officer[{{ $j }}][phone]" value="{{ old('officer.' . $j . '.phone', data_get($detail, 'officers.' . $j . '.phone')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Extension') }}</label>
                                        <input name="officer[{{ $j }}][ext]" value="{{ old('officer.' . $j . '.ext', data_get($detail, 'officers.' . $j . '.ext')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-6">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Direct Email') }}</label>
                                        <input name="officer[{{ $j }}][email]" type="email" value="{{ old('officer.' . $j . '.email', data_get($detail, 'officers.' . $j . '.email')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>

                                    <div class="md:col-span-3">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Social Security Number') }}</label>
                                        <input name="officer[{{ $j }}][ssn]" value="{{ old('officer.' . $j . '.ssn', data_get($detail, 'officers.' . $j . '.ssn')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Passport Number') }}</label>
                                        <input name="officer[{{ $j }}][passport]" value="{{ old('officer.' . $j . '.passport', data_get($detail, 'officers.' . $j . '.passport')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Country of Issuance') }}</label>
                                        <input name="officer[{{ $j }}][country]" value="{{ old('officer.' . $j . '.country', data_get($detail, 'officers.' . $j . '.country')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[10px] font-bold uppercase">{{ __('Expiration Date') }}</label>
                                        <input name="officer[{{ $j }}][expiry]" type="date" value="{{ old('officer.' . $j . '.expiry', data_get($detail, 'officers.' . $j . '.expiry')) }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" />
                                    </div>

                                    <div class="md:col-span-12 flex flex-wrap gap-4 pt-2">
                                        <span class="text-[10px] font-bold uppercase mr-2">{{ __('Passport Type:') }}</span>
                                        @foreach(['Regular','Official','Diplomatic','Card'] as $type)
                                            <label class="flex items-center text-[10px]"><input type="checkbox" name="officer[{{ $j }}][type][]" value="{{ $type }}" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-sm" {{ in_array($type, old('officer.' . $j . '.type', data_get($detail, 'officers.' . $j . '.type', []))) ? 'checked' : '' }}>
                                                {{ $type }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div x-show="step === 4" class="space-y-4" x-cloak>
                <template x-if="stepErrors.length">
                    <div class="p-3 mb-3 rounded-lg border border-red-400 bg-red-50 text-red-800 text-sm">
                        <ul class="list-disc list-inside">
                            <template x-for="error in stepErrors" :key="error">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </template>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 border-b-2 border-black pb-1 uppercase bg-gray-200 px-2">
                    4. PRIVACY & CERTIFICATION
                </h2>

                <div class="border border-black bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="border-r border-black">
                            <div class="p-1 border-b border-black min-h-[60px]">
                                <label class="block text-xs font-bold"><span class="text-red-600">*</span>{{ __('Printed or Typed Full Name (Last, First, Middle Initial):') }}</label>
                                <input name="cert_name" required value="{{ old('cert_name', data_get($detail, 'cert_name')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-8 focus:ring-0 px-1" />
                            </div>
                            <div class="p-1 min-h-[60px]">
                                <label class="block text-xs font-bold"><span class="text-red-600">*</span>{{ __('Title:') }}</label>
                                <input name="cert_title" required value="{{ old('cert_title', data_get($detail, 'cert_title')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-8 focus:ring-0 px-1" />
                            </div>
                        </div>

                        <div class="p-1 min-h-[120px] flex flex-col">
                            <label class="block text-xs font-bold"><span class="text-red-600">*</span>{{ __('Signature:') }}</label>
                            <canvas id="signatureCanvas" width="400" height="120" class="flex-grow mt-1 border border-gray-300 rounded-lg bg-white"></canvas>
                            <div class="mt-2 flex gap-2">
                                <button type="button" id="clearSignature" class="px-3 py-1 bg-gray-200 rounded">Clear</button>
                                <button type="button" id="saveSignature" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                            </div>
                            <input type="hidden" name="signature_data" id="signature_data" value="{{ old('signature_data', data_get($detail, 'signature_data')) }}">
                            <div id="signature_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 border-t border-black text-xs font-bold">
                        <div class="p-1 border-r border-black">
                            <label>{{ __('Telephone Number:') }}</label>
                            <input name="cert_phone" type="tel" value="{{ old('cert_phone', data_get($detail, 'cert_phone')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-6 focus:ring-0 px-1" />
                        </div>
                        <div class="p-1 border-r border-black">
                            <label><span class="text-red-600">*</span>{{ __('Date:') }}</label>
                            <input name="cert_date" type="date" required value="{{ old('cert_date', data_get($detail, 'cert_date')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-6 focus:ring-0 px-1" />
                        </div>
                        <div class="p-1 border-r border-black">
                            <label>{{ __('Broker Name:') }}</label>
                            <input name="broker_name" value="{{ old('broker_name', data_get($detail, 'broker_name')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-6 focus:ring-0 px-1" />
                        </div>
                        <div class="p-1">
                            <label>{{ __('Telephone Number:') }}</label>
                            <input name="broker_phone" type="tel" value="{{ old('broker_phone', data_get($detail, 'broker_phone')) }}" class="mt-1 block w-full border-none bg-blue-50 dark:bg-gray-700 h-6 focus:ring-0 px-1" />
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const canvas = document.getElementById('signatureCanvas');
                        if (!canvas) return;
                        const ctx = canvas.getContext('2d');
                        let drawing = false;
                        let lastX = 0;
                        let lastY = 0;

                        function getPos(e) {
                            const rect = canvas.getBoundingClientRect();
                            const x = (e.touches ? e.touches[0].clientX : e.clientX) - rect.left;
                            const y = (e.touches ? e.touches[0].clientY : e.clientY) - rect.top;
                            return { x, y };
                        }

                        function start(e) {
                            e.preventDefault();
                            drawing = true;
                            const p = getPos(e);
                            lastX = p.x;
                            lastY = p.y;
                        }

                        function draw(e) {
                            if (!drawing) return;
                            e.preventDefault();
                            const p = getPos(e);
                            ctx.strokeStyle = '#000';
                            ctx.lineWidth = 2;
                            ctx.lineCap = 'round';
                            ctx.beginPath();
                            ctx.moveTo(lastX, lastY);
                            ctx.lineTo(p.x, p.y);
                            ctx.stroke();
                            lastX = p.x;
                            lastY = p.y;
                        }

                        function stop() {
                            drawing = false;
                        }

                        canvas.addEventListener('mousedown', start);
                        canvas.addEventListener('touchstart', start, { passive: false });
                        canvas.addEventListener('mousemove', draw);
                        canvas.addEventListener('touchmove', draw, { passive: false });
                        canvas.addEventListener('mouseup', stop);
                        canvas.addEventListener('mouseleave', stop);
                        canvas.addEventListener('touchend', stop);

                        const signatureInput = document.getElementById('signature_data');
                        const preview = document.getElementById('signature_preview');

                        function renderPreview(data) {
                            if (!data) {
                                preview.innerHTML = '';
                                return;
                            }
                            preview.innerHTML = '<img src="' + data + '" class="h-20 border border-gray-300" />';
                        }

                        document.getElementById('clearSignature').addEventListener('click', function () {
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            signatureInput.value = '';
                            renderPreview('');
                        });

                        document.getElementById('saveSignature').addEventListener('click', function () {
                            const dataUrl = canvas.toDataURL('image/png');
                            signatureInput.value = dataUrl;
                            renderPreview(dataUrl);
                        });

                        if (signatureInput.value) {
                            renderPreview(signatureInput.value);
                        }
                    });
                </script>

                <div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded-lg text-xs text-gray-700 dark:text-gray-200 space-y-2">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-gray-100">PRIVACY ACT STATEMENT</h3>
                    <p>{{ __('Pursuant to 5 U.S.C. § 552a(e)(3), this Privacy Act Statement serves to inform you of why DHS is requesting the information on this form.') }}</p>
                    <p class="font-bold">{{ __('AUTHORITY:') }}</p>
                    <p>{{ __('The U.S. Customs and Border Protection (CBP) is authorized to collect the information requested on this form pursuant to Title 19 of the Code of Federal Regulations (19 CFR §24.5 Filing Identification Number and 149.3 Data Elements). CBP has the authority to collect Social Security numbers (SSN) under Executive Order (E.O.) 9397, as amended by E.O. 13478 (Pursuant to 31 U.S.C. §7701(c), 26 U.S.C. §6109(d), 19 C.F.R. §24.5 and §149.3).') }}</p>
                    <p class="font-bold">{{ __('PURPOSE:') }}</p>
                    <p>{{ __('CBP is requesting this information to collect and maintain records on all commercial goods imported into the United States, along with carrier, broker, importer, and other ACE-ITDS Portal user account and manifest information. CBP will use this information to track, control, and process all commercial goods imported into the United States. This facilitates the flow of legitimate shipments, and assists the Department of Homeland (DHS)/CBP in targeting illicit goods.') }}</p>
                    <p class="font-bold">{{ __('ROUTINE USES:') }}</p>
                    <p>{{ __('The information requested on this form may be shared externally, as a “routine use” with appropriate federal, state, local, tribal, or foreign governmental agencies, or multilateral governmental organizations, to assist DHS in investigating or prosecuting the violations of, or for enforcing or implementing, a statute, rule, regulation, order, license, or treaty or when DHS determines the information would assist in the enforcement of civil or criminal laws. A complete list of the routine uses can be found in the system of records notice associated with this form, “DHS/CBP-001 Import Information System.” The Department’s full list of system of records notices can be found on the Department’s website at ') }}<a href="http://www.dhs.gov/system-records-notices-sorns" class="text-blue-600 hover:underline" target="_blank" rel="noopener">http://www.dhs.gov/system-records-notices-sorns</a>{{ __('.') }}</p>
                    <p class="font-bold">{{ __('CONSEQUENCES OF FAILURE TO PROVIDE INFORMATION:') }}</p>
                    <p>{{ __('Providing this information is voluntary. However, failure to provide the information will result in the denial of a CBP-assigned importer number/importer of record identification (ID) number, and inability to pay import related duties, taxes, and fees related to an entry of imported goods. Individuals who do not provide this information may be required to use a separate party for transactions, which may affect or delay the importation of shipments in international trade.') }}</p>
                </div>

                <div class="p-2 text-sm leading-snug text-gray-800 dark:text-gray-200">
                    {{ __('By my signature below, I certify that, to the best of my knowledge and belief, all of the information included in this document is true, correct, and provided in good faith. I understand that if I make an intentional false statement, or commit deception or fraud in this 5106 document, I may be fined or imprisoned (18 U.S.C. § 1001).') }}
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="privacyAgreed" name="privacyAgreed" value="1" x-model="privacyAgreed" class="rounded text-blue-600" />
                    <label for="privacyAgreed" class="text-sm text-gray-700 dark:text-gray-200">{{ __('I have read and agree to the Privacy Act Statement.') }}</label>
                </div>
            </div>

            <div x-show="step === 5" class="space-y-6" x-cloak>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 border-b-2 border-black pb-1 uppercase">5. INSTRUCTIONS</h2>

                <div class="bg-white dark:bg-gray-800 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="max-h-[600px] overflow-y-auto p-6 space-y-8 text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                        <section>
                            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-gray-900 dark:text-white">Type of Action</h3>
                            <div class="space-y-2">
                                <p><strong>Notification of Identification Number</strong> - Check this box if this is your first request for services with CBP, or if your current Importer Number is inactive and you wish to activate this number.</p>
                                <p><strong>Change of Name</strong> - Check this box if the Importer Number is on file but there is a change in the name.</p>
                                <p><strong>Change of Address</strong> - Check this box if the Importer Number is on file but there is a change in the address.</p>
                                <p class="italic text-xs bg-yellow-50 p-2 border-l-4 border-yellow-400"><strong>NOTE:</strong> If a "Change of Address" and/or "Change of Name" is requested for an importer or other party that has an active bond on file with CBO, then a name and/or address rider must accompany this change document, unless the rider is otherwise not required for the bond pursuant to a CBP test announced in the Federal Register, such as CBP's eBond Test Program, or otherwise not required by CBP's regulations.</p>
                            </div>
                        </section>

                        <section>
                            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-gray-900 dark:text-white">Section 1 - Name and Identification Number</h3>
                            <div class="space-y-3 text-xs">
                                <p><strong>1A - Importer/Business/Private Name</strong> - Indicate the full legal name of the company or individual who will be importing or seeking service or payment. If you are submitting this document as a consignee to the import transaction, sections 1 and 2 must be filled out completely.</p>
                                <p><strong>1B - IRS/SSN</strong> - Complete this block if you are assigned an Internal Revenue Service (IRS) employer identification number or Social Security Number (SSN). If neither an IRS employer identification number nor a Social Security Number (SSN) has been assigned, click the “NONE” check box. The SSN should belong to the principal or owner of the company.</p>
                                <p><strong>1C - DIV/AKA/DBA</strong> - Complete this block if an importer is a division of another company (DIV), is also known under another name (AKA), or conducts business under another name (DBA).</p>
                                <p><strong>1D -</strong>Complete this block only if Block 1C is used.</p>
                                <p><strong>1E - Request CBP-Assigned Number</strong> - Complete this block if you have neither an IRS employer identification number nor a SSN and you require a CBP-assigned number, or, you choose to use a CBP-assigned number in lieu of your SSN. If you have an IRS employer identification number at the time you submit this form that number will automatically become your importer identification number and no CBP-assigned number will be issued. <strong>NOTE:</strong> A CBP-assigned number is for CBP use only and does not replace listing a SSN or IRS employer identification number on this form. If you have elected to request a CBP-Assigned Number in lieu of your SSN, you must provide your Company Position Title, Name, and SSN in block 3J of this form. In general, a CBP-assigned number will be issued to foreign businesses or individuals, provided no IRS employer identification number or SSN exists for the requester. A requester can choose to keep using the CBP-assigned number even if the individual subsequently acquires a SSN. If block 1E is completed, CBP will issue an assigned number and inform the requester. This identification number will be used for all future CBP transactions when an identification number is required. If an IRS employer identification number, a Social Security Number, or both, are obtained after an identification number has been assigned by CBP, a new CBP Form 5106 form shall not be filed unless requested by CBP.</p>
                                <p><strong>1F - CBP-Assigned Number -</strong> Complete this block if you have already been assigned a CBP-Assigned Number, and there is a requested change in Block "TYPE OF ACTION"</p>
                                <p><strong>1G - Type of Company -</strong> Select the description that accurately describes your company. A Limited Liability Company (LLC) is not a corporation; it is a legal form of company that provides limited liability to its owners.</p>
                                <p><strong>1H</strong> Provide an estimate of the number of entries that will be imported into the U.S. in one year, if you are an importer of record.</p>
                                <p><strong>1I -</strong> Check the boxes which will indicate how the name and identification number will be utilized. If the role of the party is not listed, you can select “Other” and then list the specific role for the party. (ex., Transportation carrier, Licensed Customs Brokerage Firm, Container Freight Station, Commercial Warehouse/Foreign Trade Zone Operator, Container Examination Station or Deliver to Party).</p>
                                <p><strong>1J thru 1M - </strong>If you are currently an active participant in a CBP Partnership Program(s), provide the program code in Block 1J thru Block 1M of the revised CBP Form 5106 and the information that is contained in Section 3 of the revised CBP Form will not be required. (ex., Customs Trade Partnership Against Terrorism - CTPAT, Importer Self-Assessment - ISA)</p>
                            </div>
                        </section>

                        <section>
                            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-gray-900 dark:text-white">Section 2 - Address Information</h3>
                            <div class="space-y-4 text-xs">
                                <div>
                                    <h4 class="font-bold underline mb-1">2A - MAILING ADDRESS (Mailing Address for the named business entity or individual referenced in section 1)</h4>
                                    <p><strong>Street Address 1 - </strong> This block must always be completed. It may or may not be the physical location. Insert a post office box number or a street number representing the first line of the mailing address. For a U.S. or Canadian mailing address, additional mailing address information may be inserted. If a P.O. Box number is given for the mailing address, a second address (physical location) must be provided in 2B. This line can be no more than 32 characters long.</p>
                                    <p><strong>Street Address 2 - </strong> If applicable, this block must always be completed with the apartment, suite, floor, and/or room number. This line can be no more than 32 characters long.</p>
                                    <p><strong>City - </strong> Insert the city name of the importer's mailing address.</p>
                                    <p><strong>State/Province - </strong> For a U.S. mailing address, insert a valid 2-position alphabetic U.S. state postal code. For a Canadian mailing address, insert a 2-character alphabetic code representing the province of the importer's mailing address.</p>
                                    <p><strong>Zip Code - </strong> For a U.S. mailing address, insert a 5 or 9-digit numeric ZIP code as established by the U.S. Postal Service. For a Canadian mailing address, insert a Canadian postal routing code. For a Mexican mailing address, leave blank. For all other foreign mailing addresses, a postal routing code may be inserted.</p>
                                    <p><strong>Country ISO Code - </strong> For a U.S. mailing address, leave blank. For any foreign mailing address, including Canada and Mexico, insert a 2-character alphabetic International Standards Organization (ISO) Code representing the country.</p>
                                    <p><strong>Type of Address - </strong>Check the box that describes this address.</p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                                    <h4 class="font-bold underline mb-1">2B - PHYSICAL LOCATION ADDRESS</h4>
                                    <p class="mb-2">Provide the address that is associated with the business or the individual. This address cannot be a P.O. Box, Business Service Center, etc. The address associated with the business can be the principal's home address. The Physical Location Address does not need to be provided on the form if it is the same as the mailing address.</p>
                                    <p class="mb-2"><strong>Street Address 1</strong> - If the place of business is the same as the mailing address, leave blank. If different from the mailing address, insert the company's business address in this space. A second address representing the company's place of business is to be provided if the mailing address is a post office box or drawer. This line can be no more than 32 characters long.</p>
                                    <p class="mb-2"><strong>Street Address 2</strong> - If applicable, this block must always be completed with the apartment, suite, floor, and/or room number. This line can be no more than 32 characters long.</p>
                                    <p class="mb-2"><strong>City</strong> - Insert the city name for the business address.</p>
                                    <p class="mb-2"><strong>State/Province</strong> - For a U.S. address, insert a 2-character alphabetic U.S. state postal code. For a Canadian address, insert a 2-character alphabetic code representing the province of the importer's business address.</p>
                                    <p class="mb-2"><strong>Zip Code</strong> - For a U.S. business address, insert a 5 or 9-digit numeric ZIP code as established by the U.S. Postal Service. For a Canadian address, insert a Canadian postal routing code. For a Mexican address, leave blank. For all other foreign addresses, a postal routing code may be inserted.</p>
                                    <p class="mb-2"><strong>Country ISO Code</strong> - For a U.S. address, leave blank. For any foreign address, including Canada and Mexico, insert a 2-character alphabetic ISO code representing the country.</p>
                                    <p class="mb-2"><strong>Type of Address</strong> - Check the box which describes this address.</p>
                                    <p class="mb-2"><strong>2C - Phone Number</strong> - The phone number and extension.</p>
                                    <p class="mb-2"><strong>2D - Fax Number</strong> - The fax number.</p>
                                    <p class="mb-2"><strong>2E - E-mail Address</strong> - The e-mail.</p>
                                    <p class="mb-2"><strong>2F - Website</strong> - The website.</p>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-gray-900 dark:text-white">Section 3 - Company Information</h3>
                            <div class="space-y-3 text-xs">
                                <p>In most cases, the data elements in this section are optional. However, if the "I have a SSN, but wish to use a CBP-assigned number on all my entry documents" option was selected in Block 1E, you <strong>must</strong> provide your Company Position Title, Name, and SSN in Block 3J.</p>
                                <p>The absence of this information will affect CBP's ability to fully understand the level of risk on subsequent transactions and could result in the delay of cargo release or the processing of a refund.</p>
                                <p><strong>3A</strong> - Provide a brief description of your business.</p>
                                <p><strong>3B</strong> - Complete this field if you know the North American Industry Classification System (NAICS) code as defined by the Department of Commerce. Provide your 6-digit NAICS code.</p>
                                <p><strong>3C</strong> - If available, provide the Dun &amp; Bradstreet Number for the name that was presented in section 1.</p>
                                <p><strong>3D</strong> - If you are an importer who is a self-filer and are using your own filer code, or a broker who also has maintained an identification number, provide the filer code that you will be using to conduct business with CBP.</p>
                                <p><strong>3E</strong> - Indicate the year in which your company was established.</p>
                                <p><strong>3F</strong> - Related Businesses Information - List the name and IRS employer identification number, Social Security Number or CBP assigned number for each related business and indicate if it is a current or previous related business.</p>
                                <p><strong>3G</strong> - Indicate the primary banking information for the company that is listed in section 1.</p>
                                <p><strong>3H</strong> - Certificate or Articles of Incorporation - Provide the 2-digit State or insert a 2-character alphabetic ISO Code representing the country in which the articles of incorporation for the business were filed (as applicable).</p>
                                <p><strong>3I</strong> - Certificate or Articles of Incorporation - Provide the file, reference, entity, issuance or unique identifying number for the certificate or articles of incorporation or business registration number or the foreign articles of incorporation (as applicable).</p>
                                <p><strong>3J</strong> - Business Structure/Beneficial Owner/Company Officer - The Beneficial Owner is any individual or group of individuals that, either directly or indirectly, has the power to vote or influence the transaction decisions regarding a specific security or one who has the benefits of ownership of a Security (finance) or property and yet does not nominally own the asset itself. Beneficial Owner/Company Officers must have importing and financial business knowledge of the company listed in section 1 and the legal authority to make decisions on behalf of the company listed in section 1 with respect to that knowledge. In most instances, the SSN or Passport Number, Country of Issuance, Passport Expiration Date, and Passport Type, in the absence of a SSN, are optional in this block. However, if the "I have a SSN, but wish to use a CBP-assigned number on all my entry documents" option is selected in Block 1E, your Company Position Title, Name, and SSN must be provided in this block.</p>
                            </div>
                        </section>

                        <section class="bg-gray-100 dark:bg-gray-900 p-4 border border-gray-200 text-[10px] uppercase">
                            <h3 class="font-bold mb-1">PAPERWORK REDUCTION ACT STATEMENT:</h3>
                            <p>An agency may not conduct or sponsor an information collection and a person is not required to respond to this information unless it displays a current valid OMB control number and an expiration date. The control number for this collection is 1651-0064. The estimated average time to complete this application is 45 minutes. The obligation to respond is required to obtain a benefit. If you have any comments regarding the burden estimate you can write to U.S. Customs and Border Protection, Office of International Trade, Regulations and Rulings, 90 K Street NE, Washington DC 20002.</p>
                        </section>
                    </div>
                </div>

                <div class="flex justify-between items-center text-[10px] font-bold text-gray-500">
                    <span>CBP Form 5106 (06/25)</span>
                    <span>Instructions Summary - Page 4 & 5</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                <button type="button" @click="step = Math.max(step - 1, 1)" :disabled="step === 1" class="px-5 py-2 rounded-lg border text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50">
                    {{ __('Previous') }}
                </button>

                <div class="flex gap-2">
                    <button type="button" x-show="step < 5" @click="goNext()" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        {{ __('Next') }}
                    </button>
                    <button type="submit" x-show="step === 5" :disabled="!privacyAgreed" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('Submit Form 5106') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
