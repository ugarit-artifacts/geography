<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\Location\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when saving the translation of a Location for one locale.
 *
 * Addressed by an attached translation model, or by location_id + locale code.
 */
class SaveLocationTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $location_id  The translated location.
     * @param  string|null  $locale  Locale code ("ar", "en").
     * @param  string|null  $name  Translated name.
     * @param  string|null  $address_line  Translated address line.
     */
    public function __construct(
        public ?int $location_id = null,
        public ?string $locale = null,
        public ?string $name = null,
        public ?string $address_line = null,
    ) {}
}
