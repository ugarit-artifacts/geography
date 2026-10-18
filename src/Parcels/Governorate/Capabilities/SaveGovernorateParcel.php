<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Governorate attributes to save: an attached model is updated, otherwise one is created.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class SaveGovernorateParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  int|null  $country_id  The country_id column.
     * @param  string|null  $slug  The slug column.
     * @param  string|null  $code  The code column.
     * @param  bool|null  $active  The active column.
     */
    public function __construct(
        public ?int $id = null,
        public ?int $country_id = null,
        public ?string $slug = null,
        public ?string $code = null,
        public ?bool $active = null,
    ) {}
}
