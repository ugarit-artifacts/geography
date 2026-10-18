<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Governorate\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Governorate to edit: an attached model, or its id.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class EditGovernorateParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     */
    public function __construct(
        public ?int $id = null,
    ) {}
}
