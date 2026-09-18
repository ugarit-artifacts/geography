<?php

declare(strict_types=1);

use Heritage\Database\Migrations\Migration;
use Heritage\Database\Schema\Blueprint;
use Heritage\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geography_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governorate_id')->constrained('geography_governorates')->cascadeOnDelete();
            $table->string('name');
            $table->string('postal_code', 20)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geography_cities');
    }
};
