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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('invoice_date');
            $table->string('invoice_number')->nullable();
            $table->string('invoice_file_path')->nullable();
            $table->string('exporter_name')->nullable();
            $table->text('exporter_address')->nullable();
            $table->string('exporter_city_zip')->nullable();
            $table->string('exporter_country')->nullable();
            $table->string('exporter_phone')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('consignee_name')->nullable();
            $table->text('consignee_address')->nullable();
            $table->string('consignee_city_zip')->nullable();
            $table->string('consignee_country')->nullable();
            $table->string('consignee_phone')->nullable();
            $table->string('consignee_contact')->nullable();
            $table->string('reference_tax_id')->nullable();
            $table->string('total_gross_weight')->nullable();
            $table->string('transportation')->nullable();
            $table->string('consignee_tax_id')->nullable();
            $table->string('other_info')->nullable();
            $table->string('total_pieces')->nullable();
            $table->string('awb_bl_number')->nullable();
            $table->string('currency')->nullable();
            $table->text('terms_of_sale')->nullable();
            $table->json('commodities')->nullable();
            $table->string('subtotal_amount')->nullable();
            $table->string('freight_cost')->nullable();
            $table->string('insurance_cost')->nullable();
            $table->string('total_invoice_value')->nullable();
            $table->string('signer_name')->nullable();
            $table->longText('signature_data')->nullable();
            $table->date('signature_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
