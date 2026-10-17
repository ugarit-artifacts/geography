<?php

namespace Ugarit\Artifacts\Geography\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Ugarit\Artifacts\Geography\Models\City;
use Ugarit\Artifacts\Geography\Models\District;

/**
 * Unified factory for District entities and their multilingual translations.
 *
 * @extends Factory<District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'slug' => $this->faker->unique()->slug(),
            'code' => $this->faker->words(2, true),
            'postal_code' => $this->faker->words(2, true),
            'active' => true,
            'name' => $this->faker->words(2, true),
        ];
    }
}
