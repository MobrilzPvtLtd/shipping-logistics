<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('importer_name')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_ein')->nullable();
            $table->string('id_ssn')->nullable();
            $table->string('id_cbp')->nullable();
            $table->boolean('request_cbp_number')->default(false);
            $table->json('cbp_form_data')->nullable();
            $table->string('existing_cbp_number')->nullable();
            $table->json('company_types')->nullable();
            $table->string('entries_year')->nullable();
            $table->json('use_cases')->nullable();
            $table->string('use_other')->nullable();
            $table->string('prog_code_1')->nullable();
            $table->string('prog_code_2')->nullable();
            $table->string('prog_code_3')->nullable();
            $table->string('prog_code_4')->nullable();

            $table->string('mailing_street_1')->nullable();
            $table->string('mailing_street_2')->nullable();
            $table->string('mailing_city')->nullable();
            $table->string('mailing_state')->nullable();
            $table->string('mailing_zip')->nullable();
            $table->string('mailing_country')->nullable();
            $table->json('mailing_address_types')->nullable();
            $table->string('mailing_address_other')->nullable();
            $table->boolean('same_as_mailing')->default(false);

            $table->string('physical_street_1')->nullable();
            $table->string('physical_street_2')->nullable();
            $table->string('physical_city')->nullable();
            $table->string('physical_state')->nullable();
            $table->string('physical_zip')->nullable();
            $table->string('physical_country')->nullable();
            $table->json('physical_address_types')->nullable();
            $table->string('physical_address_other')->nullable();

            $table->string('phone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->text('business_description')->nullable();
            $table->string('naics_code')->nullable();
            $table->string('duns_number')->nullable();
            $table->string('filer_code')->nullable();
            $table->string('year_established')->nullable();
            $table->json('related_businesses')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_routing')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_state')->nullable();
            $table->string('bank_country')->nullable();

            $table->string('inc_locator_id')->nullable();
            $table->string('inc_ref_number')->nullable();
            $table->json('officers')->nullable();

            $table->string('cert_name')->nullable();
            $table->string('cert_title')->nullable();
            $table->date('cert_date')->nullable();
            $table->string('cert_phone')->nullable();
            $table->string('broker_name')->nullable();
            $table->string('broker_phone')->nullable();
            $table->longText('signature_data')->nullable();
            $table->boolean('privacy_agreed')->default(false);

            $table->json('existing_compliance_documents')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
