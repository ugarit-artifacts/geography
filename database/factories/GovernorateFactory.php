<?php

namespace Ugarit\Artifacts\Geography\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Ugarit\Artifacts\Geography\Models\Country;
use Ugarit\Artifacts\Geography\Models\Governorate;

/**
 * Unified factory for Governorate entities and their multilingual translations.
 *
 * @extends Factory<Governorate>
 */
class GovernorateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'slug' => $this->faker->unique()->slug(),
            'code' => $this->faker->words(2, true),
            'active' => true,
            'name' => $this->faker->words(2, true),
        ];
    }
}
