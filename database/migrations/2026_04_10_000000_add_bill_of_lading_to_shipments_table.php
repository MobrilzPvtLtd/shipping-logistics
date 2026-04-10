<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->enum('bill_of_lading_method', ['structured', 'upload'])->nullable()->after('broker_phone');
            $table->json('bill_of_lading_data')->nullable()->after('bill_of_lading_method');
            $table->string('bill_of_lading_pdf')->nullable()->after('bill_of_lading_data');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['bill_of_lading_method', 'bill_of_lading_data', 'bill_of_lading_pdf']);
        });
    }
};
