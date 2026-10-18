<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Country\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Country attributes to save: an attached model is updated, otherwise one is created.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class SaveCountryParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  string|null  $code  The code column.
     * @param  string|null  $native_name  The native_name column.
     * @param  bool|null  $active  The active column.
     */
    public function __construct(
        public ?int $id = null,
        public ?string $code = null,
        public ?string $native_name = null,
        public ?bool $active = null,
    ) {}
}
