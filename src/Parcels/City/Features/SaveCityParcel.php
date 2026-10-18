<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\City\Features;

use Heritage\Parcels\Parcel;

/**
 * The City attributes to save: an attached model is updated, otherwise one is created.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class SaveCityParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  int|null  $governorate_id  The governorate_id column.
     * @param  string|null  $slug  The slug column.
     * @param  string|null  $postal_code  The postal_code column.
     * @param  bool|null  $active  The active column.
     * @param  array|null  $translations  Translated attributes keyed by locale code (["ar" => ["name" => ...]]).
     */
    public function __construct(
        public ?int $id = null,
        public ?int $governorate_id = null,
        public ?string $slug = null,
        public ?string $postal_code = null,
        public ?bool $active = null,
        public ?array $translations = null,
    ) {}
}
