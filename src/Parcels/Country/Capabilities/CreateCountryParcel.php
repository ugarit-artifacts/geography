<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Country\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The context of the Country creation form.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class CreateCountryParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     */
    public function __construct(
    ) {}
}
