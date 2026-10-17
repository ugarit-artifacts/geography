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
        Schema::createTranslatable('countries', function (Blueprint $table) {
            // Primary unique identifier
            $table->id();

            // ISO 3166-1 alpha-2. Unique among live rows; see partialUnique() below.
            $table->string('code', 2);

            // Native name (text)
            $table->string('native_name');

            // Name (text, translated)
            $table->string('name')->translatable();

            // Active (true/false flag)
            $table->boolean('active');

            // Soft deletion timestamp for auditing and data safety
            $table->softDeletes();

            // Record creation and update timestamps
            $table->timestamps();
        });

        Schema::partialUnique('countries', ['code']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExistsTranslatable('countries');
    }
};
