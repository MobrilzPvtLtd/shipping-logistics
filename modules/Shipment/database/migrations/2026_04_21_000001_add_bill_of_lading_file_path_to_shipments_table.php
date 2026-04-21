<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('shipments', 'bill_of_lading_file_path')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table
                    ->string('bill_of_lading_file_path')
                    ->nullable()
                    ->after('invoice_file_path');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('shipments', 'bill_of_lading_file_path')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->dropColumn('bill_of_lading_file_path');
            });
        }
    }
};
