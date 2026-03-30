<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number')->nullable()->unique();
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
            if (! Schema::hasColumn('users', 'payment_preference')) {
                $table->string('payment_preference')->nullable();
            }
            if (! Schema::hasColumn('users', 'door_to_door')) {
                $table->boolean('door_to_door')->default(false);
            }
            if (! Schema::hasColumn('users', 'government_id_path')) {
                $table->string('government_id_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'account_number')) {
                $table->dropColumn('account_number');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'payment_preference')) {
                $table->dropColumn('payment_preference');
            }
            if (Schema::hasColumn('users', 'door_to_door')) {
                $table->dropColumn('door_to_door');
            }
            if (Schema::hasColumn('users', 'government_id_path')) {
                $table->dropColumn('government_id_path');
            }
        });
    }
};
