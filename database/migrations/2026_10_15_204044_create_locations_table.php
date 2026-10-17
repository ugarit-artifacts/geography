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
        Schema::createTranslatable('locations', function (Blueprint $table) {
            // Primary unique identifier
            $table->id();

            // Reference to the related city (optional)
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();

            // Reference to the related district (optional)
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();

            // Unique among live locations of the same district, or the same city when no district is set
            $table->string('slug');

            // Latitude, eight decimal places (about a millimetre)
            $table->decimal('latitude', 10, 8)->nullable();

            // Longitude, eight decimal places
            $table->decimal('longitude', 11, 8)->nullable();

            // Postal code (text, optional)
            $table->string('postal_code')->nullable();

            // Name (text, translated)
            $table->string('name')->translatable();

            // Address line (text, translated)
            $table->string('address_line')->translatable();

            // Active (true/false flag)
            $table->boolean('active');

            // Soft deletion timestamp for auditing and data safety
            $table->softDeletes();

            // Record creation and update timestamps
            $table->timestamps();
        });

        Schema::partialUnique('locations', ['district_id', 'slug'], ['district_id' => 'not null']);
        Schema::partialUnique('locations', ['city_id', 'slug'], ['district_id' => 'null', 'city_id' => 'not null']);
        Schema::partialUnique('locations', ['slug'], ['city_id' => 'null', 'district_id' => 'null']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExistsTranslatable('locations');
    }
};
