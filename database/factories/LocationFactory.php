<?php

namespace Ugarit\Artifacts\Geography\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Ugarit\Artifacts\Geography\Models\District;
use Ugarit\Artifacts\Geography\Models\Location;

/**
 * Unified factory for Location entities and their multilingual translations.
 *
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => District::factory(),
            'city_id' => fn (array $attributes) => District::query()->whereKey($attributes['district_id'])->value('city_id'),
            'slug' => $this->faker->unique()->slug(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'postal_code' => $this->faker->words(2, true),
            'active' => true,
            'name' => $this->faker->words(2, true),
            'address_line' => $this->faker->words(2, true),
        ];
    }
}
