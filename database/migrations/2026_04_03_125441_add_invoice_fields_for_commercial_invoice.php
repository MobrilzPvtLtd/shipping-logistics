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
        Schema::table('invoices', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'exporter_city_zip',
                'exporter_country',
                'exporter_phone',
                'consignee_city_zip',
                'consignee_country',
                'consignee_phone',
                'consignee_contact',
                'consignee_tax_id',
                'other_info',
                'signer_name',
                'signature_date',
            ]);
        });
    }
};
