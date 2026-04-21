<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('shipments', 'bill_of_lading_data')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->json('bill_of_lading_data')->nullable()->after('bill_of_lading_file_path');
            });
        }

        if (! Schema::hasColumn('shipments', 'excise_tax_data')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->json('excise_tax_data')->nullable()->after('bill_of_lading_data');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('shipments', 'bill_of_lading_data') || Schema::hasColumn('shipments', 'excise_tax_data')) {
            Schema::table('shipments', function (Blueprint $table) {
                $columns = [];
                Schema::hasColumn('shipments', 'bill_of_lading_data') && $columns[] = 'bill_of_lading_data';
                Schema::hasColumn('shipments', 'excise_tax_data') && $columns[] = 'excise_tax_data';

                if ($columns) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
