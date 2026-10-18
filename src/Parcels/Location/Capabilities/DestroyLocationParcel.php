<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities;

use Heritage\Parcels\Parcel;

/**
 * The Location to delete: an attached model or its id, and whether to delete it permanently.
 *
 * Built with fromArray()/fromRequest(), the parcel remembers which keys were provided:
 * toAttributes() returns only those, so a key sent as null clears its column while an
 * omitted key leaves it untouched.
 */
class DestroyLocationParcel extends Parcel
{
    /**
     * Create a new Parcel instance.
     *
     * @param  int|null  $id  The record identifier.
     * @param  bool  $force  Whether to delete it permanently.
     */
    public function __construct(
        public ?int $id = null,
        public bool $force = false,
    ) {}
}
