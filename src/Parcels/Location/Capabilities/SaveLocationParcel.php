<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Location attributes to save: an attached model is updated, otherwise one is created.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class SaveLocationParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  int|null  $city_id  The city_id column.
     * @param  int|null  $district_id  The district_id column.
     * @param  string|null  $slug  The slug column.
     * @param  float|null  $latitude  The latitude column.
     * @param  float|null  $longitude  The longitude column.
     * @param  string|null  $postal_code  The postal_code column.
     * @param  bool|null  $active  The active column.
     */
    public function __construct(
        public ?int $id = null,
        public ?int $city_id = null,
        public ?int $district_id = null,
        public ?string $slug = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $postal_code = null,
        public ?bool $active = null,
    ) {}
}
