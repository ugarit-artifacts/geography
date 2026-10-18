<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Location to edit: an attached model, or its id.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class EditLocationParcel extends Parcel
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
