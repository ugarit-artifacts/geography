<?php

namespace Ugarit\Artifacts\Geography\Database\Seeders;

use Heritage\Database\Seeder;
use Ugarit\Artifacts\Geography\Models\Country;

/**
 * Database seeder for Country entities.
 */
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // The fixed records, then 10 random ones (localized across active locales if translatable)
        $this->seedModel(Country::class, 10);
    }

    /**
     * The fixed records, a translatable attribute given per locale.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function records(): array
    {
        return [
            //
        ];
    }
}
