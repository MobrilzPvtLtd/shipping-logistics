<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->integer('units');
            $table->decimal('length_cm', 10, 2);
            $table->decimal('width_cm', 10, 2);
            $table->decimal('height_cm', 10, 2);
            $table->decimal('weight_kg', 10, 2);
            $table->text('condition_notes')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

