<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The context of the Location creation form.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class CreateLocationParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     */
    public function __construct(
    ) {}
}
