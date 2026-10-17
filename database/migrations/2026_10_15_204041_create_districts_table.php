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
        Schema::createTranslatable('districts', function (Blueprint $table) {
            // Primary unique identifier
            $table->id();

            // Reference to the related city
            $table->foreignId('city_id')->constrained();

            // Unique among the live districts of one city
            $table->string('slug');

            // Code (text, optional)
            $table->string('code')->nullable();

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

        Schema::partialUnique('districts', ['city_id', 'slug']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExistsTranslatable('districts');
    }
};
