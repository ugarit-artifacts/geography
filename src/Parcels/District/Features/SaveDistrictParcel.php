<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\District\Features;

use Heritage\Parcels\Parcel;

/**
 * The District attributes to save: an attached model is updated, otherwise one is created.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class SaveDistrictParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  int|null  $city_id  The city_id column.
     * @param  string|null  $slug  The slug column.
     * @param  string|null  $code  The code column.
     * @param  string|null  $postal_code  The postal_code column.
     * @param  bool|null  $active  The active column.
     * @param  array|null  $translations  Translated attributes keyed by locale code (["ar" => ["name" => ...]]).
     */
    public function __construct(
        public ?int $id = null,
        public ?int $city_id = null,
        public ?string $slug = null,
        public ?string $code = null,
        public ?string $postal_code = null,
        public ?bool $active = null,
        public ?array $translations = null,
    ) {}
}
