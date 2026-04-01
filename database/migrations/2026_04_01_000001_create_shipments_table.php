<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tracking_number')->nullable()->unique();
            $table->string('sender_name')->nullable();
            $table->string('receiver_name')->nullable();
            $table->text('origin_address')->nullable();
            $table->text('destination_address')->nullable();
            $table->decimal('weight_kg', 10, 2)->nullable();
            $table->integer('package_count')->nullable();
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'cancelled'])->default('pending');
            $table->text('description')->nullable();

            // CBP fields
            $table->string('importer_name')->nullable();
            $table->enum('id_type', ['EIN', 'SSN', 'CBP', 'REQUEST_CBP'])->nullable();
            $table->string('id_ein')->nullable();
            $table->string('id_ssn')->nullable();
            $table->string('id_cbp')->nullable();
            $table->boolean('type_div')->default(false);
            $table->boolean('type_aka')->default(false);
            $table->boolean('type_dba')->default(false);
            $table->json('type_of_action')->nullable();
            $table->string('dba_name')->nullable();
            $table->boolean('request_cbp_number')->default(false);
            $table->json('request_cbp_reasons')->nullable();
            $table->string('existing_cbp_number')->nullable();
            $table->json('comp_type')->nullable();
            $table->string('entries_year')->nullable();
            $table->json('use')->nullable();
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
            $table->json('mailing_address_type')->nullable();
            $table->string('mailing_address_other')->nullable();

            $table->string('physical_street_1')->nullable();
            $table->string('physical_street_2')->nullable();
            $table->string('physical_city')->nullable();
            $table->string('physical_state')->nullable();
            $table->string('physical_zip')->nullable();
            $table->string('physical_country')->nullable();
            $table->json('physical_address_type')->nullable();
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
            $table->integer('year_established')->nullable();
            $table->json('related')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_routing')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_state')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('inc_locator_id')->nullable();
            $table->string('inc_ref_number')->nullable();
            $table->json('officer')->nullable();
            $table->string('cert_name')->nullable();
            $table->string('cert_title')->nullable();
            $table->text('signature_data')->nullable();
            $table->string('cert_phone')->nullable();
            $table->date('cert_date')->nullable();
            $table->string('broker_name')->nullable();
            $table->string('broker_phone')->nullable();

            $table->json('cbp_form_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
