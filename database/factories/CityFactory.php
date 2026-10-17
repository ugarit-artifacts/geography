<?php

namespace Ugarit\Artifacts\Geography\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Unified factory for City entities and their multilingual translations.
 *
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'governorate_id' => Governorate::factory(),
            'slug' => $this->faker->unique()->slug(),
            'postal_code' => $this->faker->words(2, true),
            'active' => true,
            'name' => $this->faker->words(2, true),
        ];
    }
}
