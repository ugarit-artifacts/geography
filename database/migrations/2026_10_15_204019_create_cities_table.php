<?php

declare(strict_types=1);

use Heritage\Database\Migrations\Migration;
use Heritage\Database\Schema\Blueprint;
use Heritage\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createTranslatable('cities', function (Blueprint $table) {
            // Primary unique identifier
            $table->id();

            // Reference to the related governorate
            $table->foreignId('governorate_id')->constrained();

            // Unique among the live cities of one governorate
            $table->string('slug');

            // Postal code (text, optional)
            $table->string('postal_code')->nullable();

            // Name (text, translated)
            $table->string('name')->translatable();

            // Active (true/false flag)
            $table->boolean('active');

            // Soft deletion timestamp for auditing and data safety
            $table->softDeletes();

            // Record creation and update timestamps
            $table->timestamps();
        });

        Schema::partialUnique('cities', ['governorate_id', 'slug']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExistsTranslatable('cities');
    }
};
