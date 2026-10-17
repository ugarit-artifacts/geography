<?php

namespace Ugarit\Artifacts\Geography\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Unified factory for Country entities and their multilingual translations.
 *
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('??')),
            'native_name' => $this->faker->words(2, true),
            'active' => true,
            'name' => $this->faker->words(2, true),
        ];
    }
}
