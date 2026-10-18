<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when deleting the translation of a City.
 *
 * Addressed by an attached translation model, or by city_id + locale code.
 */
class DestroyCityTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $city_id  The translated city.
     * @param  string|null  $locale  Locale code ("ar", "en").
     */
    public function __construct(
        public ?int $city_id = null,
        public ?string $locale = null,
    ) {}
}
