<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when deleting the translation of a Location.
 *
 * Addressed by an attached translation model, or by location_id + locale code.
 */
class DestroyLocationTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $location_id  The translated location.
     * @param  string|null  $locale  Locale code ("ar", "en").
     */
    public function __construct(
        public ?int $location_id = null,
        public ?string $locale = null,
    ) {}
}
