<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Parcels\City\Capabilities\Translation;

use Heritage\Parcels\Parcel;

/**
 * Parcel used when saving the translation of a City for one locale.
 *
 * Addressed by an attached translation model, or by city_id + locale code.
 */
class SaveCityTranslationParcel extends Parcel
{
    /**
     * Create a new parcel instance.
     *
     * @param  int|null  $city_id  The translated city.
     * @param  string|null  $locale  Locale code ("ar", "en").
     * @param  string|null  $name  Translated name.
     */
    public function __construct(
        public ?int $city_id = null,
        public ?string $locale = null,
        public ?string $name = null,
    ) {}
}
