<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('exporter_name')->nullable();
            $table->text('exporter_address')->nullable();
            $table->string('consignee_name')->nullable();
            $table->text('consignee_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('reference_tax_id')->nullable();
            $table->decimal('total_gross_weight', 12, 2)->nullable();
            $table->string('transportation')->nullable();
            $table->string('terms_of_sale')->nullable();
            $table->integer('total_pieces')->nullable();
            $table->string('awb_bl_number')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('subtotal_amount', 15, 2)->nullable();
            $table->decimal('freight_cost', 15, 2)->nullable();
            $table->decimal('insurance_cost', 15, 2)->nullable();
            $table->decimal('total_invoice_value', 15, 2)->nullable();
            $table->text('commodity_description')->nullable();
            $table->string('hs_code')->nullable();
            $table->string('country_of_manufacture')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('line_total', 15, 2)->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();
            $table->string('exporter_city_zip')->nullable();
            $table->string('exporter_country')->nullable();
            $table->string('exporter_phone')->nullable();
            $table->string('consignee_city_zip')->nullable();
            $table->string('consignee_country')->nullable();
            $table->string('consignee_phone')->nullable();
            $table->string('consignee_contact')->nullable();
            $table->string('consignee_tax_id')->nullable();
            $table->string('other_info')->nullable();
            $table->string('signer_name')->nullable();
            $table->date('signature_date')->nullable();
            $table->text('signature_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
