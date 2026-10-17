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
        Schema::createTranslatable('governorates', function (Blueprint $table) {
            // Primary unique identifier
            $table->id();

            // Reference to the related country
            $table->foreignId('country_id')->constrained();

            // Unique among the live governorates of one country
            $table->string('slug');

            // Code (text, optional)
            $table->string('code')->nullable();

            // Name (text, translated)
            $table->string('name')->translatable();

            // Active (true/false flag)
            $table->boolean('active');

            // Soft deletion timestamp for auditing and data safety
            $table->softDeletes();

            // Record creation and update timestamps
            $table->timestamps();
        });

        Schema::partialUnique('governorates', ['country_id', 'slug']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExistsTranslatable('governorates');
    }
};
